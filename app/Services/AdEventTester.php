<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class AdEventTester
{
    public function send(string $platform, Request $request): array
    {
        $settings = Setting::groupValues('tracking');

        return match ($platform) {
            'meta' => $this->sendMeta($settings),
            'tiktok' => $this->sendTikTok($settings, $request),
            'google' => $this->prepareGoogle($settings),
            default => throw new RuntimeException('Platform test tidak dikenali.'),
        };
    }

    private function sendMeta(array $settings): array
    {
        $pixelId = $this->required($settings, 'meta_pixel_id', 'Meta Pixel ID');
        $token = $this->required($settings, 'meta_capi_token', 'Meta Conversions API Token');
        $testCode = $this->required($settings, 'meta_test_event_code', 'Meta Test Event Code');
        $eventId = 'temoe_test_meta_'.Str::uuid();
        $payload = [
            'data' => [[
                'event_name' => 'Lead',
                'event_time' => now()->timestamp,
                'event_id' => $eventId,
                'action_source' => 'website',
                'event_source_url' => url('/admin/tracking'),
                'user_data' => [
                    'em' => [hash('sha256', 'test@temoetumbuh.web.id')],
                    'ph' => [hash('sha256', '6280000000000')],
                    'external_id' => [hash('sha256', 'temoe-dummy-user')],
                    'client_user_agent' => 'TemoeTumbuh-TestEvent/1.0',
                ],
                'custom_data' => [
                    'content_name' => 'Temoe Tumbuh Dummy Lead',
                    'content_category' => 'Integration Test',
                    'currency' => 'IDR',
                    'value' => 0,
                    'test_event' => true,
                ],
            ]],
            'test_event_code' => $testCode,
            'access_token' => $token,
        ];

        $response = Http::asJson()->timeout(12)->retry(1, 250)
            ->post("https://graph.facebook.com/v23.0/{$pixelId}/events", $payload);
        $body = $response->json() ?: ['body' => Str::limit($response->body(), 1500)];
        $accepted = $response->successful() && (int) data_get($body, 'events_received', 0) > 0;

        return [
            'platform' => 'Meta',
            'success' => $accepted,
            'message' => $accepted
                ? 'Meta menerima dummy Lead. Cek Events Manager → Test Events.'
                : 'Meta menolak event. Periksa Pixel ID, token, Test Event Code, dan detail respons.',
            'http_status' => $response->status(),
            'event_id' => $eventId,
            'payload' => $this->redactMeta($payload),
            'response' => $body,
        ];
    }

    private function sendTikTok(array $settings, Request $request): array
    {
        $pixelId = $this->required($settings, 'tiktok_pixel_id', 'TikTok Pixel ID');
        $token = $this->required($settings, 'tiktok_events_api_token', 'TikTok Events API Token');
        $testCode = $this->required($settings, 'tiktok_test_event_code', 'TikTok Test Event Code');
        $eventId = 'temoe_test_tiktok_'.Str::uuid();
        $payload = [
            'event_source' => 'web',
            'event_source_id' => $pixelId,
            'data' => [[
                'event' => 'SubmitForm',
                'event_time' => now()->timestamp,
                'event_id' => $eventId,
                'user' => [
                    'email' => hash('sha256', 'test@temoetumbuh.web.id'),
                    'phone_number' => hash('sha256', '6280000000000'),
                    'external_id' => hash('sha256', 'temoe-dummy-user'),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent() ?: 'TemoeTumbuh-TestEvent/1.0',
                ],
                'properties' => [
                    'content_type' => 'product',
                    'content_name' => 'Temoe Tumbuh Dummy Registration',
                    'content_id' => 'temoe-dummy-lead',
                    'currency' => 'IDR',
                    'value' => 0,
                ],
                'page' => [
                    'url' => url('/admin/tracking'),
                    'referrer' => url('/admin'),
                ],
            ]],
            'test_event_code' => $testCode,
        ];

        $response = Http::asJson()->withHeaders(['Access-Token' => $token])
            ->timeout(12)->retry(1, 250)
            ->post('https://business-api.tiktok.com/open_api/v1.3/event/track/', $payload);
        $body = $response->json() ?: ['body' => Str::limit($response->body(), 1500)];
        $accepted = $response->successful() && (int) data_get($body, 'code', -1) === 0;

        return [
            'platform' => 'TikTok',
            'success' => $accepted,
            'message' => $accepted
                ? 'TikTok menerima dummy SubmitForm. Cek Events Manager → Test Events.'
                : 'TikTok menolak event. Periksa Pixel ID, access token, Test Event Code, dan detail respons.',
            'http_status' => $response->status(),
            'event_id' => $eventId,
            'payload' => $this->redactTikTok($payload),
            'response' => $body,
        ];
    }

    private function prepareGoogle(array $settings): array
    {
        $conversionId = $this->required($settings, 'google_ads_conversion_id', 'Google Ads Conversion ID');
        $conversionLabel = $this->required($settings, 'google_ads_conversion_label', 'Google Ads Conversion Label');
        $eventId = 'TEMOE_TEST_'.now()->format('YmdHis').'_'.Str::upper(Str::random(6));
        $payload = [
            'command' => 'event',
            'event_name' => 'conversion',
            'send_to' => $conversionId.'/'.$conversionLabel,
            'currency' => 'IDR',
            'value' => 0,
            'transaction_id' => $eventId,
            'event_category' => 'integration_test',
            'event_label' => 'temoe_dummy_conversion',
        ];

        return [
            'platform' => 'Google Ads',
            'success' => true,
            'browser_dispatch' => true,
            'message' => 'Dummy conversion disiapkan dan dikirim browser dengan nilai Rp0. Cek Google Ads setelah proses pencatatan selesai.',
            'http_status' => null,
            'event_id' => $eventId,
            'payload' => $payload,
            'response' => ['status' => 'queued_by_google_tag'],
        ];
    }

    private function required(array $settings, string $key, string $label): string
    {
        $value = trim((string) ($settings[$key] ?? ''));
        if ($value === '') throw new RuntimeException($label.' belum diisi.');
        return $value;
    }

    private function redactMeta(array $payload): array
    {
        $payload['access_token'] = '[TERSIMPAN SEBAGAI SECRET — TIDAK DITAMPILKAN]';
        $payload['test_event_code'] = '[TEST CODE TERPASANG]';
        return $payload;
    }

    private function redactTikTok(array $payload): array
    {
        $payload['test_event_code'] = '[TEST CODE TERPASANG]';
        $payload['data'][0]['user']['ip'] = '[IP ADMIN YANG MENEKAN TEST]';
        $payload['data'][0]['user']['user_agent'] = '[USER AGENT ADMIN YANG MENEKAN TEST]';
        return $payload;
    }
}
