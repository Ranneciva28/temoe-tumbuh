<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingSettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::groupValues('tracking');
        return view('admin.settings.tracking', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'meta_pixel_id' => ['nullable', 'string', 'max:255'],
            'meta_capi_token' => ['nullable', 'string', 'max:2000'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:255'],
            'google_ads_conversion_id' => ['nullable', 'string', 'max:255'],
            'google_ads_conversion_label' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            if ($key === 'meta_capi_token' && ($value === null || $value === '')) {
                continue;
            }
            Setting::put('tracking', $key, $value, $key === 'meta_capi_token');
        }

        return back()->with('success', 'Konfigurasi tracking diperbarui.');
    }
}
