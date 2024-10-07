<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
    {
        $chart = Chart::with('product')->get();

        return view('users.chart', compact('chart'));
    }

    public function store(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir jika diperlukan
        $request->validate([
            'size' => 'required',
            'qty' => 'required|numeric|min:1', // Contoh validasi untuk field qty
        ]);
    
        // Ambil user_id dari user yang sedang login
        $user_id = Auth::user()->id;
    
        // Ambil data produk berdasarkan product_id
        $product = Product::find($id);
    
        // Hitung total harga chart saat ini
        $totalPrice = Chart::sum('price');
    
        // Hitung total berat dari keranjang belanjaan saat ini
        $totalWeight = Chart::sum('weight');
    
        // Cek apakah chart sudah ada dengan produk yang sama dan ukuran yang sama
        $existingChart = Chart::where('product_id', $id)
            ->where('size', $request->input('size'))
            ->first();
    
        if ($existingChart) {
            // Jika ada entri dengan produk yang sama dan ukuran yang sama,
            // tambahkan qty yang baru ke qty yang sudah ada
            $existingChart->qty += $request->input('qty');
            $existingChart->price += $product->product_price * $request->input('qty');
            $existingChart->total_chart += $product->product_price * $request->input('qty');
    
            // Hitung total berat baru dengan menambahkan berat produk baru (dikali qty baru) ke total berat yang sudah ada
            $existingChart->total_weight += $product->weight * $request->input('qty');
    
            $existingChart->save();
        } else {
            // Jika tidak ada entri dengan produk yang sama dan ukuran yang sama,
            // buat entri baru di tabel Chart
            $chart = new Chart();
            $chart->user_id = $user_id;
            $chart->product_id = $id; // Gunakan product_id dari parameter rute
            $chart->product = $product->product_name;
            $chart->weight = $product->weight;
            $chart->qty = $request->input('qty');
            $chart->size = $request->input('size');
            $chart->price = $product->product_price * $request->input('qty');
            $chart->total_chart = $totalPrice + ($product->product_price * $request->input('qty'));
    
            // Hitung total berat baru dengan menambahkan berat produk baru (dikali qty baru) ke total berat yang sudah ada
            $newWeight = $totalWeight + ($product->weight * $request->input('qty'));
            $chart->total_weight = $newWeight;
    
            $chart->save();
        }
    
        return redirect('/chart');
    }
    

}
