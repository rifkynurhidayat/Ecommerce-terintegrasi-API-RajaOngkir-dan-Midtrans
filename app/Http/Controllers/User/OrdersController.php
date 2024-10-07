<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Product;
use App\Models\SettingDiskonOngkir;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $chart = Order::with('product')->get();
        return view('users.chart');
    }

    public function order(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'size' => 'required',
            'qty' => 'required|numeric|min:1',
        ]);

        $selectedSize = $request->input('size');
        $availableStock = $product->{'stock_' . $selectedSize};

        if ($request->input('qty') > $availableStock) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi untuk ukuran yang dipilih.');
        }

        $tanggal = Carbon::now();
        $user_id = Auth::user()->id;

        $order = Order::where('user_id', $user_id)->where('status', 'pending')->first();
        if (empty($order)) {
            $order = new Order;
            $order->user_id = $user_id;
            $order->order_date = $tanggal;
            $order->total_weight = 0;
            $order->total_price = 0;
            $order->save();
        }

        // Cek apakah ada order_item dengan produk_id yang sama dan size yang sama
        $cek_order_item = Order_items::where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->where('size', $request->size)
            ->first();

        if (empty($cek_order_item)) {
            // Cek apakah ada order_item dengan produk_id yang sama tapi size yang berbeda
            $cek_order_item_with_same_product = Order_items::where('product_id', $product->id)
                ->where('order_id', $order->id)
                ->first();

            if ($cek_order_item_with_same_product) {
                // Jika ada order_item dengan produk_id yang sama tapi size yang berbeda,
                // maka buat order_item baru dengan ukuran yang berbeda
                $order_item = new Order_items;
                $order_item->product_id = $product->id;
                $order_item->order_id = $order->id;
                $order_item->qty = $request->qty;
                $order_item->size = $request->size;
                $order_item->item_weight = $product->weight * $request->qty;
                $order_item->total_items = $product->product_price * $request->qty;
                $order_item->save();
            } else {
                // Jika tidak ada order_item dengan produk_id yang sama dan size yang sama,
                // maka buat order_item baru
                $order_item = new Order_items;
                $order_item->product_id = $product->id;
                $order_item->order_id = $order->id;
                $order_item->qty = $request->qty;
                $order_item->size = $request->size;
                $order_item->item_weight = $product->weight * $request->qty;
                $order_item->total_items = $product->product_price * $request->qty;
                $order_item->save();
            }
        } else {
            // Jika sudah ada order_item dengan produk_id dan size yang sama, update order_item tersebut
            $order_item = $cek_order_item;
            $order_item->qty += $request->qty;
            $order_item->item_weight += $request->qty;
            // Harga sekarang
            $harga_order_item = $product->product_price * $request->qty;
            $weight_item = $product->weight * $request->qty;
            $order_item->item_weight += $weight_item;
            $order_item->total_items += $harga_order_item;
            $order_item->save();
        }

        // Jumlah total
        $order->total_weight += $product->weight * $request->qty;
        $order->total_price += $product->product_price * $request->qty;

        $order->save();
        alert()->success('SuccessAlert', 'Lorem ipsum dolor sit amet.');
        return redirect('/order');
    }

    public function addOrder()
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', 'pending')->first();

        $order_item = Order_items::where('order_id', $order->id)->get();

        $diskon_ongkir = SettingDiskonOngkir::getSettings()['min_trx'] <= $order->total_price;

        return view('users.chart', compact('order', 'order_item', 'diskon_ongkir'));
    }
    public function batal($id)
    {
        $order_item = Order_items::where('id', $id)->first();

        $order = Order::where('id', $order_item->order_id)->first();
        $order->total_price = $order->total_price - $order_item->total_items;
        $order->total_weight = $order->total_weight - $order_item->item_weight;
        $order->update();

        $order_item->delete();
        Alert::error('Pesanan dihapus', 'Hapus');
        return redirect('/order');
    }

    public function update(Request $request, $id)
    {
        // Find the order item
        $order_item = Order_items::findOrFail($id);

        // Find the associated order
        $order = Order::findOrFail($order_item->order_id);

        // Validasi input
        $request->validate([
            'qty' => 'required|numeric|min:1', // Validasi jumlah yang dipesan
        ]);

        // Calculate the difference in quantity
        $difference = $request->qty - $order_item->qty;

        // Calculate the price difference based on the quantity difference
        $price_difference = $order_item->product->product_price * $difference;
        $weight_difference = $order_item->product->weight * $difference;

        // Check if requested quantity exceeds available stock
        $requested_qty = $request->qty;
        $current_stock = $order_item->product->{"stock_" . $order_item->size};

        if ($requested_qty > $current_stock) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi untuk jumlah yang dipilih.');
        }

        // Update the quantity in the order item
        $order_item->qty = $requested_qty;
        $order_item->item_weight = $order_item->product->weight * $requested_qty;
        $order_item->total_items = $order_item->product->product_price * $requested_qty;

        $order_item->save();

        // Update the total price of the order
        $order->total_price += $price_difference;
        $order->total_weight += $weight_difference;
        $order->save();

        // Sync stock in product table based on size of the order item
        $product = $order_item->product;
        $product->{"stock_" . $order_item->size} -= $difference;
        $product->save();

        return redirect()->back()->with('success', 'Pesanan berhasil diperbarui.');
    }
}
