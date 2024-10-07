<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProdukDilihat;
use App\Support\ProductCollection;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $category = Categories::all();
        $produk = Product::with(['categories', 'avgRating'])->get();

        $unggulan = Product::unggulan(3);
        $preferensi = null;
        $ratingTinggi = null;

        if ($request->user()) {
            $preferensi = $request->user()->preferensi(3);
        } else {
            $ratingTinggi = Product::ratingTertinggi(3);
        }

        $seringDilihat = Product::seringDilihat(3);

        return view('users.home', compact(
            'category',
            'produk',
            'unggulan',
            'preferensi',
            'seringDilihat',
            'ratingTinggi',
        ));
    }

    public function detail(Request $request, $id)
    {
        $detail = Product::with('categories', 'testimoni.user')->findOrFail($id);
        
        // Menambahkan baris kode untuk mengambil produk dengan kategori yang sama
        $kategoriSama = Product::whereHas('categories', function ($query) use ($detail) {
            $query->whereIn('id', $detail->categories->pluck('id'));
        })->where('id', '!=', $detail->id)->limit(1)->get(); // Batasi 5 produk
    
        $dilihat = new ProdukDilihat();
        $dilihat->user_id = $request->user()?->id;
        $dilihat->product_id = $detail->id;
        $dilihat->save();
    
        return view('users.product-detail', [
            'detail' => $detail,
            'kategoriSama' => $kategoriSama, // Menambahkan variabel baru untuk produk dengan kategori sama
        ]);
    }

    public function unggulan()
    {
        $title = 'Produk Unggulan';
        $unggulan = Product::unggulan(15);

        return view('users.list-products', ['products' => $unggulan, 'title' => $title]);
    }
    public function preferensi(Request $request)
    {
        $title = 'Produk Preferensi Anda';

        $preferensi = $request->user()->preferensi(15);
        return view('users.list-products', ['products' => $preferensi, 'title' => $title]);
    }
    public function rating_tertinggi()
    {
        $title = 'Produk Dengan Rating Tertinggi';

        $ratingTinggi = Product::ratingTertinggi(15);

        return view('users.list-products', ['products' => $ratingTinggi, 'title' => $title]);
    }
    public function sering_dilihat()
    {
        $title = 'Produk Yang Sering Dilihat';

        $seringDilihat = Product::seringDilihat(15);

        return view('users.list-products', ['products' => $seringDilihat, 'title' => $title]);
    }

   
}
