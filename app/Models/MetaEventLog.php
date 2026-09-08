<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaEventLog extends Model
{
    protected $fillable = [
        'meta_event_mapping_id', 'event_name', 'trigger_type', 'target_key',
        'event_id', 'channel', 'status', 'page_url', 'metadata',
    ];

    protected $casts = ['metadata' => 'array'];

    public function mapping(): BelongsTo
    {
        return $this->belongsTo(MetaEventMapping::class, 'meta_event_mapping_id');
    }
}
