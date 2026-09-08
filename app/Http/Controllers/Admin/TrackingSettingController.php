<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaEventLog;
use App\Models\MetaEventMapping;
use App\Models\Setting;
use App\Services\AdEventTester;
use App\Services\MetaEventCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class TrackingSettingController extends Controller
{
    public function edit(MetaEventCatalog $catalog): View
    {
        $settings = Setting::groupValues('tracking');
        $metaMappings = MetaEventMapping::query()->latest()->get();
        $metaLogs = MetaEventLog::query()->latest()->limit(100)->get();
        $metaEvents = MetaEventCatalog::EVENTS;
        $metaTriggers = MetaEventCatalog::TRIGGERS;
        $metaTargets = $catalog->targets();
        $metaTargetLabels = collect($metaTargets)->pluck('label', 'key');

        return view('admin.settings.tracking', compact(
            'settings', 'metaMappings', 'metaLogs', 'metaEvents',
            'metaTriggers', 'metaTargets', 'metaTargetLabels'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'meta_pixel_id' => ['nullable', 'string', 'max:255'],
            'meta_capi_token' => ['nullable', 'string', 'max:2000'],
            'meta_test_event_code' => ['nullable', 'string', 'max:255'],
            'tiktok_pixel_id' => ['nullable', 'string', 'max:255'],
            'tiktok_events_api_token' => ['nullable', 'string', 'max:2000'],
            'tiktok_test_event_code' => ['nullable', 'string', 'max:255'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:255'],
            'google_ads_conversion_id' => ['nullable', 'string', 'max:255'],
            'google_ads_conversion_label' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            if (in_array($key, ['meta_capi_token', 'tiktok_events_api_token'], true) && ($value === null || $value === '')) {
                continue;
            }
            Setting::put('tracking', $key, $value, in_array($key, ['meta_capi_token', 'tiktok_events_api_token'], true));
        }

        return back()->with('success', 'Konfigurasi tracking diperbarui.');
    }

    public function test(Request $request, string $platform, AdEventTester $tester): RedirectResponse
    {
        abort_unless(in_array($platform, ['meta', 'tiktok', 'google'], true), 404);

        try {
            $result = $tester->send($platform, $request);
        } catch (RuntimeException $e) {
            $result = [
                'platform' => ucfirst($platform),
                'success' => false,
                'message' => $e->getMessage(),
                'payload' => null,
                'response' => null,
            ];
        } catch (Throwable $e) {
            report($e);
            $result = [
                'platform' => ucfirst($platform),
                'success' => false,
                'message' => 'Koneksi ke platform gagal. Coba lagi dan periksa konfigurasi atau log aplikasi.',
                'payload' => null,
                'response' => null,
            ];
        }

        return back()->with('tracking_test_result', $result);
    }
}
