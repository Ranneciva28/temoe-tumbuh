<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Throwable;

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
            ->get()
            ->mapWithKeys(function (Setting $setting) {
                $value = $setting->value;
                if ($setting->is_secret && filled($value)) {
                    try {
                        $value = Crypt::decryptString($value);
                    } catch (Throwable) {
                        // Backward compatibility for any pre-encryption value.
                    }
                }
                return [$setting->key => $value];
            })
            ->all();
    }

    public static function put(string $group, string $key, mixed $value, bool $secret = false): void
    {
        $storedValue = $secret && filled($value)
            ? Crypt::encryptString((string) $value)
            : $value;

        static::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $storedValue, 'is_secret' => $secret]
        );
    }
}
