<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MetaConversionsApi
{
    public function sendLead(Lead $lead, Request $request): string
    {
        $eventId = 'lead_'.$lead->id;
        $settings = Setting::groupValues('tracking');
        $pixelId = $settings['meta_pixel_id'] ?? null;
        $token = $settings['meta_capi_token'] ?? null;

        if (! $pixelId || ! $token) {
            return $eventId;
        }

        $userData = array_filter([
            'em' => $lead->email ? [hash('sha256', mb_strtolower(trim($lead->email)))] : null,
            'ph' => $lead->whatsapp ? [hash('sha256', $this->normalizePhone($lead->whatsapp))] : null,
            'client_ip_address' => $lead->ip_address ?: $request->ip(),
            'client_user_agent' => $lead->user_agent ?: $request->userAgent(),
            'fbp' => $request->cookie('_fbp'),
            'fbc' => $request->cookie('_fbc') ?: $this->fbcFromClickId($lead->fbclid),
            'external_id' => [hash('sha256', 'temoe-lead-'.$lead->id)],
        ]);

        $payload = [
            'data' => [[
                'event_name' => 'Lead',
                'event_time' => now()->timestamp,
                'event_id' => $eventId,
                'action_source' => 'website',
                'event_source_url' => $lead->landing_page ?: url('/minat'),
                'user_data' => $userData,
                'custom_data' => [
                    'content_name' => 'Temoe Tumbuh Interest Form',
                    'content_category' => 'Daycare Market Validation',
                    'city' => $lead->city,
                    'lead_status' => $lead->status,
                    'reservation_interest' => $lead->reservation_interest,
                ],
            ]],
            'access_token' => $token,
        ];

        try {
            $response = Http::timeout(5)
                ->retry(1, 200)
                ->post("https://graph.facebook.com/v23.0/{$pixelId}/events", $payload);

            if (! $response->successful()) {
                Log::warning('Meta CAPI Lead event failed', [
                    'lead_id' => $lead->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (Throwable $e) {
            Log::warning('Meta CAPI Lead event exception', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
            ]);
        }

        return $eventId;
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?: '';
        if (str_starts_with($digits, '0')) return '62'.substr($digits, 1);
        if (str_starts_with($digits, '8')) return '62'.$digits;
        return $digits;
    }

    private function fbcFromClickId(?string $fbclid): ?string
    {
        if (! $fbclid) return null;
        return 'fb.1.'.now()->timestamp.'.'.$fbclid;
    }
}
