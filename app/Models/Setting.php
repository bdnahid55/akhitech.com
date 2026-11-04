<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /**
     * Cache key for settings.
     */
    public const CACHE_KEY = 'app_settings_all';

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = static::getAll();

        return $settings[$key] ?? $default;
    }

    /**
     * Set / update a setting value.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Retrieve all settings as key-value pairs (cached).
     *
     * @return array<string, mixed>
     */
    public static function getAll(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            try {
                return static::pluck('value', 'key')->toArray();
            } catch (\Throwable) {
                return [];
            }
        });
    }

    /**
     * Flush settings cache.
     */
    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
