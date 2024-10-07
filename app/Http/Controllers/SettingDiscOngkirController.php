<?php

namespace App\Http\Controllers;

use App\Models\SettingDiskonOngkir;
use Illuminate\Http\Request;

class SettingDiscOngkirController extends Controller
{
    public function edit()
    {
        $setting = SettingDiskonOngkir::getSettings();
        return view('admin.transaksi.setting-disc-ongkir', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'min_trx' => ['required', 'min:1'],
        ]);

        SettingDiskonOngkir::truncate();

        $setting = new SettingDiskonOngkir();
        $setting->min_trx = $validated['min_trx'];
        $setting->save();

        SettingDiskonOngkir::forgetCache();

        return redirect()->route('setting-disc-ongkir');
    }
}
