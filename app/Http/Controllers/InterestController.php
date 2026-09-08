<?php

namespace App\Http\Controllers;

use App\Models\FormField;
use App\Models\FormSection;
use App\Models\Lead;
use App\Models\Setting;
use App\Services\InterestFormContent;
use App\Services\MetaConversionsApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InterestController extends Controller
{
    public function create(Request $request, InterestFormContent $formContent): View
    {
        $attribution = [];
        foreach (['utm_source','utm_medium','utm_campaign','utm_content','utm_term','fbclid','gclid'] as $key) {
            $attribution[$key] = $request->old($key, $request->query($key));
        }
        $attribution['landing_page'] = $request->old('landing_page', $request->fullUrl());
        $attribution['referrer'] = $request->old('referrer', $request->headers->get('referer'));

        $content = $formContent->values();
        $sections = FormSection::query()
            ->where('form_key', 'interest')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        $activeSectionKeys = $sections->pluck('section_key');

        return view('interest.create', [
            'sections' => $sections,
            'fields' => $this->activeFields($activeSectionKeys),
            'tracking' => Setting::groupValues('tracking'),
            'attribution' => $attribution,
            'content' => $content,
        ]);
    }

    public function store(Request $request, MetaConversionsApi $meta): RedirectResponse
    {
        $rules = [
            'reservation_interest' => ['nullable','boolean'],
            'privacy_consent' => ['accepted'],
            'utm_source' => ['nullable','string','max:255'],
            'utm_medium' => ['nullable','string','max:255'],
            'utm_campaign' => ['nullable','string','max:255'],
            'utm_content' => ['nullable','string','max:255'],
            'utm_term' => ['nullable','string','max:255'],
            'fbclid' => ['nullable','string','max:2000'],
            'gclid' => ['nullable','string','max:2000'],
            'landing_page' => ['nullable','string','max:4000'],
            'referrer' => ['nullable','string','max:4000'],
        ];

        $activeSectionKeys = FormSection::query()
            ->where('form_key', 'interest')
            ->where('is_active', true)
            ->pluck('section_key');
        $fields = $this->activeFields($activeSectionKeys);
        $attributes = [];

        foreach ($fields as $field) {
            $key = $field->field_key;
            $inputKey = $field->isCore() ? $key : 'custom.'.$key;
            $options = array_values(array_filter((array) $field->options, fn ($value) => is_string($value) && $value !== ''));
            $fieldRules = [$field->is_required ? 'required' : 'nullable'];

            if ($field->type === 'checkbox') {
                $fieldRules[] = 'array';
                $fieldRules[] = 'max:100';
                $rules[$inputKey] = $fieldRules;
                if ($options) $rules[$inputKey.'.*'] = ['string', Rule::in($options)];
            } else {
                if ($key === 'child_age') {
                    array_push($fieldRules, 'integer', 'min:0', 'max:12');
                } elseif ($field->type === 'date') {
                    $fieldRules[] = 'date';
                } elseif ($field->type === 'number') {
                    $fieldRules[] = 'numeric';
                } else {
                    $fieldRules[] = $field->type === 'email' ? 'email' : 'string';
                    $fieldRules[] = 'max:'.$this->maxLengthFor($field);
                }
                if (in_array($field->type, ['select','radio'], true) && $options) {
                    $fieldRules[] = Rule::in($options);
                }
                $rules[$inputKey] = $fieldRules;
            }

            $attributes[$inputKey] = $field->label;
            $attributes[$inputKey.'.*'] = $field->label;
        }

        $validated = Validator::make($request->all(), $rules, [], $attributes)->validate();
        $data = collect($validated)
            ->only(array_merge(FormField::CORE_KEYS, [
                'utm_source','utm_medium','utm_campaign','utm_content','utm_term',
                'fbclid','gclid','landing_page','referrer',
            ]))
            ->all();

        $data['parent_name'] = filled($data['parent_name'] ?? null) ? $data['parent_name'] : 'Lead tanpa nama';
        $data['whatsapp'] = (string) ($data['whatsapp'] ?? '');
        $data['reservation_interest'] = $request->boolean('reservation_interest');
        $data['custom_fields'] = filled($validated['custom'] ?? null) ? $validated['custom'] : null;
        $data['consent_at'] = now();
        $data['consent_version'] = '2026-09-05-v1';
        $data['ip_address'] = $request->headers->get('CF-Connecting-IP') ?: $request->ip();
        $data['user_agent'] = $request->userAgent();

        $lead = Lead::create($data);
        $metaEventId = $meta->sendLead($lead, $request);

        return redirect()->route('interest.thank-you')->with('meta_event_id', $metaEventId);
    }

    public function thankYou(): View
    {
        return view('interest.thank-you', [
            'tracking' => Setting::groupValues('tracking'),
        ]);
    }

    private function activeFields($activeSectionKeys)
    {
        return FormField::query()
            ->where('form_key', 'interest')
            ->where('is_active', true)
            ->whereIn('section_key', $activeSectionKeys)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    private function maxLengthFor(FormField $field): int
    {
        return match ($field->field_key) {
            'parent_name', 'child_name', 'city', 'district', 'budget_range' => 120,
            'whatsapp' => 30,
            'email' => 160,
            'preferred_location', 'preferred_schedule' => 160,
            default => 2000,
        };
    }
}
