<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @return array<string, string|null>
     */
    public static function allAsArray(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * @param  array<string, string|null>  $settings
     */
    public static function setMany(array $settings): void
    {
        if ($settings === []) {
            return;
        }

        $rows = collect($settings)
            ->map(fn (mixed $value, string $key): array => ['key' => $key, 'value' => $value])
            ->values()
            ->all();

        static::upsert($rows, ['key'], ['value']);
    }
}
