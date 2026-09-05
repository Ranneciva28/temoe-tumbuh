<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'parent_name','whatsapp','email','child_name','child_age','city','district',
        'preferred_location','preferred_schedule','preferred_start_date','budget_range',
        'reservation_interest','status','notes','custom_fields','consent_at','consent_version',
        'utm_source','utm_medium','utm_campaign','utm_content','utm_term','fbclid','gclid',
        'referrer','landing_page','ip_address','user_agent','contacted_at','qualified_at','reserved_at',
    ];

    protected function casts(): array
    {
        return [
            'reservation_interest' => 'boolean',
            'preferred_start_date' => 'date',
            'custom_fields' => 'array',
            'consent_at' => 'datetime',
            'contacted_at' => 'datetime',
            'qualified_at' => 'datetime',
            'reserved_at' => 'datetime',
        ];
    }
}
