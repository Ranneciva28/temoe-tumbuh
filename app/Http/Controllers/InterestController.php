<?php

namespace App\Http\Controllers;

use App\Models\FormField;
use App\Models\Lead;
use App\Models\Setting;
use App\Services\MetaConversionsApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InterestController extends Controller
{
    public function create(Request $request): View
    {
        $attribution = [];
        foreach (['utm_source','utm_medium','utm_campaign','utm_content','utm_term','fbclid','gclid'] as $key) {
            $attribution[$key] = $request->old($key, $request->query($key));
        }
        $attribution['landing_page'] = $request->old('landing_page', $request->fullUrl());
        $attribution['referrer'] = $request->old('referrer', $request->headers->get('referer'));

        return view('interest.create', [
            'fields' => FormField::query()->where('form_key', 'interest')->where('is_active', true)->orderBy('sort_order')->get(),
            'tracking' => Setting::groupValues('tracking'),
            'attribution' => $attribution,
        ]);
    }

    public function store(Request $request, MetaConversionsApi $meta): RedirectResponse
    {
        $data = $request->validate([
            'parent_name' => ['required','string','max:120'],
            'whatsapp' => ['required','string','max:30'],
            'email' => ['nullable','email','max:160'],
            'child_name' => ['nullable','string','max:120'],
            'child_age' => ['nullable','integer','min:0','max:12'],
            'city' => ['nullable','string','max:120'],
            'district' => ['nullable','string','max:120'],
            'preferred_location' => ['nullable','string','max:160'],
            'preferred_schedule' => ['nullable','string','max:160'],
            'preferred_start_date' => ['nullable','date'],
            'budget_range' => ['nullable','string','max:120'],
            'reservation_interest' => ['nullable','boolean'],
            'privacy_consent' => ['accepted'],
            'utm_source' => ['nullable','string','max:255'],
            'utm_medium' => ['nullable','string','max:255'],
            'utm_campaign' => ['nullable','string','max:255'],
            'utm_content' => ['nullable','string','max:255'],
            'utm_term' => ['nullable','string','max:255'],
            'fbclid' => ['nullable','string'],
            'gclid' => ['nullable','string'],
            'landing_page' => ['nullable','string'],
            'referrer' => ['nullable','string'],
        ]);

        $fields = FormField::query()->where('form_key', 'interest')->where('is_active', true)->get();
        $rules = [];
        $attributes = [];

        foreach ($fields as $field) {
            $fieldRules = [$field->is_required ? 'required' : 'nullable'];
            $fieldRules[] = match ($field->type) {
                'email' => 'email',
                'number' => 'numeric',
                'date' => 'date',
                'checkbox' => 'array',
                default => 'string',
            };
            if ($field->type !== 'checkbox') $fieldRules[] = 'max:2000';
            $rules[$field->field_key] = $fieldRules;
            $attributes[$field->field_key] = $field->label;
        }

        $customFields = Validator::make((array) $request->input('custom', []), $rules, [], $attributes)->validate();

        unset($data['privacy_consent']);
        $data['reservation_interest'] = $request->boolean('reservation_interest');
        $data['custom_fields'] = $customFields ?: null;
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
}
