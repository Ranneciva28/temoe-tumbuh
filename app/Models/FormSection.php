<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormSection extends Model
{
    protected $fillable = [
        'form_key', 'section_key', 'title', 'description', 'sort_order',
        'is_active', 'is_protected',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_protected' => 'boolean',
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class, 'section_key', 'section_key')
            ->where('form_key', $this->form_key);
    }
}
