<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    use HasFactory;
    protected $fillable =['key','value'];

    public static function getContent($key, $default = null)
    {
        return Cache::rememberForever("page_content_{$key}", function () use ($key, $default) {
            $page = self::where('key', $key)->first();
            return $page ? json_decode($page->value, true) : $default;
        });
    }

    public static function setContent($key, $value)
    {
        Cache::forget("page_content_{$key}");
        $page = self::updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($value)]
        );
        Cache::forever("page_content_{$key}", json_decode($page->value, true));
        return $page;
    }
}
