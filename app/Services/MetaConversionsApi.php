<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\MetaEventLog;
use App\Models\MetaEventMapping;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MetaConversionsApi
{
    public function sendLead(Lead $lead, Request $request): array
    {
        $mappings = MetaEventMapping::query()
            ->where('is_active', true)
            ->where('trigger_type', 'form_success')
            ->where('target_key', 'interest_form_success')
            ->get();

        if ($mappings->isEmpty()) return [];

        $eventIds = $mappings->mapWithKeys(fn ($mapping) => [
            (string) $mapping->id => 'lead_'.$lead->id.'_mapping_'.$mapping->id,
        ])->all();

        $settings = Setting::groupValues('tracking');
        $pixelId = $settings['meta_pixel_id'] ?? null;
        $token = $settings['meta_capi_token'] ?? null;

        if (! $pixelId || ! $token) return $eventIds;

        $userData = array_filter([
            'em' => $lead->email ? [hash('sha256', mb_strtolower(trim($lead->email)))] : null,
            'ph' => $lead->whatsapp ? [hash('sha256', $this->normalizePhone($lead->whatsapp))] : null,
            'client_ip_address' => $lead->ip_address ?: $request->ip(),
            'client_user_agent' => $lead->user_agent ?: $request->userAgent(),
            'fbp' => $request->cookie('_fbp'),
            'fbc' => $request->cookie('_fbc') ?: $this->fbcFromClickId($lead->fbclid),
            'external_id' => [hash('sha256', 'temoe-lead-'.$lead->id)],
        ]);

        $events = $mappings->map(fn ($mapping) => [
            'event_name' => $mapping->event_name,
            'event_time' => now()->timestamp,
            'event_id' => $eventIds[(string) $mapping->id],
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
        ])->values()->all();

        try {
            $response = Http::timeout(5)
                ->retry(1, 200)
                ->post("https://graph.facebook.com/v23.0/{$pixelId}/events", [
                    'data' => $events,
                    'access_token' => $token,
                ]);

            $responseData = $response->json() ?: [];
            $accepted = $response->successful()
                && (int) data_get($responseData, 'events_received', 0) >= count($events);

            foreach ($mappings as $mapping) {
                $this->recordServerDelivery(
                    $mapping,
                    $eventIds[(string) $mapping->id],
                    $accepted ? 'accepted' : 'failed',
                    $lead->landing_page,
                    [
                        'lead_id' => $lead->id,
                        'http_status' => $response->status(),
                        'events_received' => data_get($responseData, 'events_received'),
                        'fbtrace_id' => data_get($responseData, 'fbtrace_id'),
                    ]
                );
            }

            if (! $accepted) {
                Log::warning('Meta CAPI mapped events failed', [
                    'lead_id' => $lead->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (Throwable $e) {
            foreach ($mappings as $mapping) {
                $this->recordServerDelivery(
                    $mapping,
                    $eventIds[(string) $mapping->id],
                    'exception',
                    $lead->landing_page,
                    ['lead_id' => $lead->id, 'message' => $e->getMessage()]
                );
            }

            Log::warning('Meta CAPI mapped event exception', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
            ]);
        }

        return $eventIds;
    }

    private function recordServerDelivery(
        MetaEventMapping $mapping,
        string $eventId,
        string $status,
        ?string $pageUrl,
        array $metadata
    ): void {
        MetaEventLog::firstOrCreate(
            ['channel' => 'server', 'event_id' => $eventId],
            [
                'meta_event_mapping_id' => $mapping->id,
                'event_name' => $mapping->event_name,
                'trigger_type' => $mapping->trigger_type,
                'target_key' => $mapping->target_key,
                'status' => $status,
                'page_url' => $pageUrl,
                'metadata' => $metadata,
            ]
        );
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
