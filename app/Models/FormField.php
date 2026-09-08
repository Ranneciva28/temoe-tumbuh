<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    public const FORM_TYPES = ['text', 'email', 'tel', 'number', 'date', 'select', 'radio', 'checkbox', 'textarea', 'hidden'];

    public const CORE_KEYS = [
        'parent_name', 'whatsapp', 'email', 'child_name', 'child_age', 'city',
        'district', 'preferred_location', 'preferred_schedule',
        'preferred_start_date', 'budget_range',
    ];

    protected $fillable = [
        'form_key','section_key','field_key','label','type','placeholder','help_text','options',
        'is_required','is_active','sort_order','validation_rules',
    ];

    protected $casts = [
        'options' => 'array',
        'validation_rules' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function isCore(): bool
    {
        return in_array($this->field_key, self::CORE_KEYS, true);
    }

    public function inputName(): string
    {
        return $this->isCore() ? $this->field_key : 'custom['.$this->field_key.']';
    }

    public function oldInputKey(): string
    {
        return $this->isCore() ? $this->field_key : 'custom.'.$this->field_key;
    }

    public static function allowedTypesForKey(string $fieldKey): array
    {
        return match ($fieldKey) {
            'parent_name', 'child_name' => ['text'],
            'whatsapp' => ['tel', 'text'],
            'email' => ['email', 'text'],
            'child_age' => ['number'],
            'city', 'preferred_schedule', 'budget_range' => ['select', 'radio', 'text'],
            'district', 'preferred_location' => ['text', 'textarea'],
            'preferred_start_date' => ['date'],
            default => self::FORM_TYPES,
        };
    }

    public function allowedTypes(): array
    {
        return self::allowedTypesForKey($this->field_key);
    }
}
