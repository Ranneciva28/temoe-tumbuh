<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InterestController extends Controller
{
    public function create(Request $request): View
    {
        return view('interest.create', [
            'attribution' => [
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_content' => $request->query('utm_content'),
                'utm_term' => $request->query('utm_term'),
                'fbclid' => $request->query('fbclid'),
                'gclid' => $request->query('gclid'),
                'landing_page' => $request->fullUrl(),
                'referrer' => $request->headers->get('referer'),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
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

        $data['reservation_interest'] = $request->boolean('reservation_interest');
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        Lead::create($data);

        return redirect()->route('interest.thank-you');
    }

    public function thankYou(): View
    {
        return view('interest.thank-you');
    }
}
