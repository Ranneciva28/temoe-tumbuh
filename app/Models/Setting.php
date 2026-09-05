<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'is_secret'];

    protected $casts = [
        'is_secret' => 'boolean',
    ];

    public static function groupValues(string $group): array
    {
        return static::query()
            ->where('group', $group)
            ->pluck('value', 'key')
            ->all();
    }

    public static function put(string $group, string $key, mixed $value, bool $secret = false): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value, 'is_secret' => $secret]
        );
    }
}
