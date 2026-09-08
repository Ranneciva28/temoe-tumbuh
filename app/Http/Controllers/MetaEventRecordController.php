<?php

namespace App\Http\Controllers;

use App\Models\MetaEventLog;
use App\Models\MetaEventMapping;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MetaEventRecordController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $data = $request->validate([
            'mapping_id' => ['required', 'integer'],
            'event_id' => ['required', 'string', 'max:180'],
            'page_url' => ['nullable', 'string', 'max:4000'],
        ]);

        $mapping = MetaEventMapping::query()
            ->whereKey($data['mapping_id'])
            ->where('is_active', true)
            ->firstOrFail();

        MetaEventLog::firstOrCreate(
            ['channel' => 'browser', 'event_id' => $data['event_id']],
            [
                'meta_event_mapping_id' => $mapping->id,
                'event_name' => $mapping->event_name,
                'trigger_type' => $mapping->trigger_type,
                'target_key' => $mapping->target_key,
                'status' => 'dispatched',
                'page_url' => $data['page_url'] ?? null,
                'metadata' => ['referrer' => $request->headers->get('referer')],
            ]
        );

        return response()->noContent();
    }
}
