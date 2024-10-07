<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SettingDiskonOngkir;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('users.checkout');
    }

    public function addCheckout($id)
    {
        $co = Order::with('user', 'order_items.product')->find($id);
        $province = $this->get_province();

        //ambil data provinsi dan kota dari user
        $user = auth()->user();
        $userProvinceId= $user->provinsi_id;
        $userCityId= $user->kota_id;

        $diskon_ongkir = SettingDiskonOngkir::getSettings()['min_trx'] <= $co->total_price;

        return view('users.checkout', ['co' => $co, 'province' => $province, 'diskon_ongkir' => $diskon_ongkir, 'userProvinceId' => $userProvinceId, 'userCityId' => $userCityId]);
    }

    public function get_province()
    {
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->get('https://api.rajaongkir.com/starter/province');
        return $response['rajaongkir']['results'];
    }


    public function get_cities($provinceId)
    {
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $provinceId,
        ]);
        return response()->json($response['rajaongkir']['results']);
    }

    public function get_ongkir($origin, $destination, $weight, $courier)
    {
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);
        return response()->json($response['rajaongkir']['results']);
    }
}
