<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormField;
use App\Models\FormSection;
use App\Models\Setting;
use App\Services\InterestFormContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FormFieldController extends Controller
{
    private const RESERVED_KEYS = [
        'reservation_interest','status','notes','privacy_consent','utm_source','utm_medium',
        'utm_campaign','utm_content','utm_term','fbclid','gclid','referrer','landing_page',
    ];

    public function index(InterestFormContent $formContent): View
    {
        $fields = FormField::query()->where('form_key', 'interest')->orderBy('sort_order')->get();
        $sections = FormSection::query()->where('form_key', 'interest')->orderBy('sort_order')->orderBy('id')->get();
        $content = $formContent->values();
        $contentGroups = $formContent->adminGroups();

        return view('admin.form-fields.index', compact('fields', 'sections', 'content', 'contentGroups'));
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (array_keys(InterestFormContent::DEFAULTS) as $key) {
            $rules[$key] = ['nullable', 'string', 'max:5000'];
        }

        $data = $request->validate($rules);
        foreach (array_keys(InterestFormContent::DEFAULTS) as $key) {
            Setting::put('interest_form', $key, $data[$key] ?? null);
        }

        return back()->with('success', 'Seluruh konten Form Minat diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['form_key'] = 'interest';
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active'] = $request->boolean('is_active');
        $data['options'] = $this->parseOptions($request->input('options_text'));
        unset($data['options_text']);
        FormField::create($data);

        return back()->with('success', 'Field formulir ditambahkan.');
    }

    public function update(Request $request, FormField $field): RedirectResponse
    {
        $data = $this->validated($request, false, $field);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active'] = $request->boolean('is_active');
        $data['options'] = $this->parseOptions($request->input('options_text'));
        unset($data['options_text']);
        $field->update($data);

        return back()->with('success', 'Field formulir diperbarui.');
    }

    public function destroy(FormField $field): RedirectResponse
    {
        $field->delete();
        return back()->with('success', 'Field formulir dihapus. Jawaban historis pada lead tetap tersimpan.');
    }

    private function validated(Request $request, bool $requireKey = true, ?FormField $field = null): array
    {
        $fieldKeyRules = [$requireKey ? 'required' : 'sometimes', 'nullable', 'regex:/^[a-z0-9_]+$/', 'max:100'];
        if ($requireKey) {
            $fieldKeyRules[] = Rule::notIn(self::RESERVED_KEYS);
            $fieldKeyRules[] = Rule::unique('form_fields', 'field_key')->where(fn ($query) => $query->where('form_key', 'interest'));
        }

        $fieldKey = $requireKey ? (string) $request->input('field_key') : (string) $field?->field_key;

        return $request->validate([
            'section_key' => [
                'required',
                'string',
                Rule::exists('form_sections', 'section_key')
                    ->where(fn ($query) => $query->where('form_key', 'interest')),
            ],
            'field_key' => $fieldKeyRules,
            'label' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(FormField::allowedTypesForKey($fieldKey))],
            'placeholder' => ['nullable', 'string', 'max:255'],
            'help_text' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_required' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'options_text' => ['nullable', 'string', 'max:5000'],
        ], [
            'field_key.not_in' => 'Field key tersebut dipakai oleh sistem Temoe Tumbuh dan tidak dapat digunakan sebagai field form.',
            'field_key.unique' => 'Field key tersebut sudah dipakai pada Form Minat.',
            'type.in' => 'Tipe jawaban tersebut tidak cocok dengan penyimpanan field inti yang dipilih.',
        ]);
    }

    private function parseOptions(?string $text): ?array
    {
        if (! $text) return null;

        $items = collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->unique()
            ->take(100)
            ->values()
            ->all();

        return $items ?: null;
    }
}
