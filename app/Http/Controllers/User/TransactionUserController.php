<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\SettingDiskonOngkir;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionUserController extends Controller
{
    public function transaction(Request $request, $id)
    {
        $co = Order::with('user', 'order_items.product')->find($id);
        $tanggal = Carbon::now();

        $kurir = $request->input('kurir');
        $response = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => '211',
            'destination' => $request->input('kota_id'),
            'weight' => $co->total_weight,
            'courier' => $kurir
        ]);

        $service = $request->input('layanan');

        $result = collect($response['rajaongkir']['results'])->keyBy('code');
        $costs = collect($result[$kurir]['costs'])->keyBy('service');
        $ongkir = $costs[$service]['cost'][0]['value'];

        $disc_ongkir = 0;

        $punya_disc_ongkir = SettingDiskonOngkir::getSettings()['min_trx'] <= $co->total_price;

        if ($request->input('disc-ongkir', false) && $punya_disc_ongkir) {
            $disc_ongkir = $ongkir * -1;
        }

        $transaksi = new Transaction;
        $transaksi->order_id = $co->id;
        $transaksi->user_id = $co->user->id;
        $transaksi->transaction_date = $tanggal;
        $transaksi->province = $response['rajaongkir']['destination_details']['province'];
        $transaksi->city_name = $response['rajaongkir']['destination_details']['city_name'];
        $transaksi->kode_pos = $response['rajaongkir']['destination_details']['postal_code'];
        $transaksi->courier = $response['rajaongkir']['query']['courier'];
        $transaksi->service = $service;
        $transaksi->ongkir = $ongkir;
        $transaksi->discount = $disc_ongkir * -1;
        $transaksi->total_payment = $ongkir + $co->total_price + $disc_ongkir;
        $transaksi->save();

        $order = Order::with('order_items.product')->findOrFail($id);
        // Update jumlah stok produk
        foreach ($order->order_items as $order_item) {
            // Ambil produk dari order item
            $product = $order_item->product;

            // Kurangi jumlah stok produk sesuai dengan ukuran yang dipesan
            switch ($order_item->size) {
                case 's':
                    $product->stock_s -= $order_item->qty;
                    break;
                case 'm':
                    $product->stock_m -= $order_item->qty;
                    break;
                case 'l':
                    $product->stock_l -= $order_item->qty;
                    break;
                case 'xl':
                    $product->stock_xl -= $order_item->qty;
                    break;
                    // Tambahkan penanganan untuk ukuran lain jika diperlukan
            }

            // Simpan perubahan pada stok produk
            $product->save();
        }


        $co->status = 'success';
        $co->save();

        return redirect('/invoice/' . $transaksi->id);
    }

    public function getSnapToken(Request $request, $id)
    {
        $co = Order::with('user', 'order_items.product')->find($id);

        $kurir = $request->input('kurir');
        $response_ro = Http::asForm()->withHeaders([
            'key' => 'e36a143f6a692a3a859420f7a6feff66',
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => '211',
            'destination' => $request->input('kota_id'),
            'weight' => $co->total_weight,
            'courier' => $kurir
        ]);

        $service = $request->input('layanan');

        $result = collect($response_ro['rajaongkir']['results'])->keyBy('code');
        $costs = collect($result[$kurir]['costs'])->keyBy('service');
        $ongkir = $costs[$service]['cost'][0]['value'];

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $order_id = $co->id . time();

        $itemDetail = [];
        foreach ($co->order_items as $item) {
            $itemDetail[] = [
                "id" => $item->id,
                "price" => $item->product->product_price,
                "quantity" => $item->qty,
                "name" => $item->product->product_name,
            ];
        }
        $itemDetail[] = [
            "id" => 'O01',
            "price" => $ongkir,
            "quantity" => 1,
            "name" => "Ongkos Kirim",
        ];

        $disc_ongkir = 0;

        $punya_disc_ongkir = SettingDiskonOngkir::getSettings()['min_trx'] <= $co->total_price;

        if ($request->input('disc-ongkir', false) && $punya_disc_ongkir) {
            $disc_ongkir = $ongkir * -1;

            $itemDetail[] = [
                "id" => 'O02',
                "price" => $disc_ongkir,
                "quantity" => 1,
                "name" => "Diskon Ongkos Kirim",
            ];
        }

        $totalPayment = $ongkir + $co->total_price + $disc_ongkir;

        $dest = $response_ro['rajaongkir']['destination_details'];

        $snapToken = \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $totalPayment,
            ],
            'item_details' => $itemDetail,
            'customer_details' => [
                'name' => $co->user->name,
                'email' => $co->user->email,
                "shipping_address" => [
                    'name' => $co->user->name,
                    'email' => $co->user->email,
                    "address" => "Kab/Kota: {$dest['city_name']} Provinsi: {$dest['province']} Kode Pos: {$dest['postal_code']}",
                    "city" => $dest['city_name'],
                    "postal_code" => $dest['postal_code'],
                    "country_code" => "IDN"
                ]
            ],
            "enabled_payments" => [
                "bca_va",
                "bni_va",
                "bri_va",
            ],
        ]);

        return response()->json(['snapToken' => $snapToken]);
    }

    public function invoice($id)
    {
        $transaction = Transaction::with('order.user', 'order.order_items.product')->find($id);
        return view('users.invoice', ['transaction' => $transaction]);
    }
}
