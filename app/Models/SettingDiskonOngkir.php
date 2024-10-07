<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SettingDiskonOngkir extends Model
{
    use HasFactory;
    protected $table = 'setting_diskon_ongkir';

    const DEFAULTS = [
        'min_trx' => 300000,
    ];

    public static function getSettings(): array
    {
        $setting = Cache::remember('setting_diskon_ongkir', 10, function () {
            return static::orderBy('id', 'desc')->first();
        });

        return [
            'min_trx' => $setting?->min_trx ?? static::DEFAULTS['min_trx'],
        ];
    }

    public static function forgetCache()
    {
        Cache::forget('setting_diskon_ongkir');
    }
}
