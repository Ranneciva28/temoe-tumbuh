<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = [
        'form_key','field_key','label','type','placeholder','help_text','options',
        'is_required','is_active','sort_order','validation_rules',
    ];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];
}
