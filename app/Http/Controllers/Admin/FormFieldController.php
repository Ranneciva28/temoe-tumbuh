<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormField;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FormFieldController extends Controller
{
    private const RESERVED_KEYS = [
        'parent_name','whatsapp','email','child_name','child_age','city','district',
        'preferred_location','preferred_schedule','preferred_start_date','budget_range',
        'reservation_interest','status','notes','privacy_consent','utm_source','utm_medium',
        'utm_campaign','utm_content','utm_term','fbclid','gclid','referrer','landing_page',
    ];

    public function index(): View
    {
        $fields = FormField::query()->where('form_key', 'interest')->orderBy('sort_order')->get();
        return view('admin.form-fields.index', compact('fields'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['form_key'] = 'interest';
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active'] = $request->boolean('is_active');
        $data['options'] = $this->parseOptions($request->input('options_text'));
        unset($data['options_text']);
        FormField::create($data);

        return back()->with('success', 'Field formulir ditambahkan.');
    }

    public function update(Request $request, FormField $field): RedirectResponse
    {
        $data = $this->validated($request, false);
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

    private function validated(Request $request, bool $requireKey = true): array
    {
        $fieldKeyRules = [$requireKey ? 'required' : 'sometimes', 'nullable', 'regex:/^[a-z0-9_]+$/', 'max:100'];
        if ($requireKey) {
            $fieldKeyRules[] = Rule::notIn(self::RESERVED_KEYS);
            $fieldKeyRules[] = Rule::unique('form_fields', 'field_key')->where(fn ($query) => $query->where('form_key', 'interest'));
        }

        return $request->validate([
            'field_key' => $fieldKeyRules,
            'label' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:text,email,tel,number,date,select,radio,checkbox,textarea,hidden'],
            'placeholder' => ['nullable', 'string', 'max:255'],
            'help_text' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_required' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'options_text' => ['nullable', 'string', 'max:5000'],
        ], [
            'field_key.not_in' => 'Field key tersebut dipakai oleh field inti Temoe Tumbuh.',
            'field_key.unique' => 'Field key tersebut sudah dipakai pada Form Minat.',
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
