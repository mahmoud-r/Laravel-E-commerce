<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    use HasFactory;
    protected $fillable =['key','value'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        Cache::forget('settings');
        $settings = static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::put('settings', $settings, 60*60);
        return $settings;
    }

}
