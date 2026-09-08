<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetaEventMapping extends Model
{
    protected $fillable = ['event_name', 'trigger_type', 'target_key', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function logs(): HasMany
    {
        return $this->hasMany(MetaEventLog::class);
    }
}
