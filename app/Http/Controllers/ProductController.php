<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{  
 
    public function index()
    {
        $product = Product::with('categories')->get();
        return view('admin.product.product', ['produk' => $product]);
        
    }

    public function create()
    {
         $category = Categories::select('id', 'category_name')->get();
         return view('admin.product.product-add',['category' => $category]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories_id' => 'required',
            'product_name' => 'unique:products|required',
            'product_price' => 'required',
            'stock_s' => 'required',
            'stock_m' => 'required',
            'stock_l' => 'required',
            'stock_xl' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'img_product.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Validasi untuk jumlah foto produk
        if (count($request->file('img_product')) != 4) {
            return redirect('/produk-add')->with('status', 'error')->with('message', 'Harus mengunggah 4 foto produk.');
        }
    
        $images = [];
        foreach ($request->file('img_product') as $file) {
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $newName = $request->product_name . '-' . now()->timestamp . '-' . rand(1000, 9999) . '.' . $extension;
                // Simpan di storage/app/public/admin
                $file->storeAs('admin', $newName);
                $images[] = $newName;
            } else {
                return redirect('/produk')->with('status', 'error')->with('message', 'Gagal menambahkan data produk. File gambar tidak sesuai.');
            }
        }
    
        $product = new Product;
        $product->categories_id = $request->categories_id;
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->stock_s = $request->stock_s;
        $product->stock_m = $request->stock_m;
        $product->stock_l = $request->stock_l;
        $product->stock_xl = $request->stock_xl;
        $product->weight = $request->weight;
        $product->description = $request->description;
    
        // Mengonversi array $images menjadi string dipisahkan dengan koma
        $product->img_product = implode(',', $images);
    
        $product->save();
    
        // Menggunakan alert atau pesan sukses (misalnya menggunakan SweetAlert)
        Alert::success('Success Title', 'Produk berhasil ditambahkan.');
    
        return redirect('/produk');
    }
    

    
    public function edit(Request $request, $id){

        $product = Product::with('categories')->findOrFail($id);
        $categories = Categories::where('id', '!=', $product->categories_id)->get(['id', 'category_name']);
        return view('admin.product.product-edit', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $validated = $request->validate([
            'categories_id' => 'required',
            'product_name' => 'unique:products,product_name,' . $id . '|required',
            'product_price' => 'required',
            'stock_s' => 'required',
            'stock_m' => 'required',
            'stock_l' => 'required',
            'stock_xl' => 'required',
            'description' => 'required',
            'weight' => 'requireed',
            'img_product.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $images = [];
        if ($request->hasFile('img_product')) {
            foreach ($request->file('img_product') as $file) {
                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $newName = $request->product_name . '-' . now()->timestamp . '-' . rand(1000, 9999) . '.' . $extension;
                    $file->storeAs('admin', $newName);
                    $images[] = $newName;
                } else {
                    Session::flash('status', 'error');
                    Session::flash('message', 'Gagal menambahkan data produk. File gambar tidak sesuai.');
                    return redirect('/produk');
                }
            }
        }
    
        // Update data produk yang ada
        $product->categories_id = $request->categories_id;
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->stock_s = $request->stock_s;
        $product->stock_m = $request->stock_m;
        $product->stock_l = $request->stock_l;
        $product->stock_xl = $request->stock_xl;
        $product->weight = $product->weight;
        $product->description = $request->description;
    
        // Mengonversi array $images menjadi string dipisahkan dengan koma
        $product->img_product = implode(',', $images);
    
        $product->save();
    
        if ($product) {
            Session::flash('status', 'success');
            Session::flash('message', 'Berhasil edit produk');
        } else {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menambahkan data produk. File gambar tidak sesuai.');
        }
    
        return redirect('/produk');
    }
    


    public function delete($id)
    {
        $product = Product::findOrFail($id);
    
        // Hapus gambar terkait sebelum menghapus data produk
        if (Storage::disk('public')->exists('admin/' . $product->img_product)) {
            Storage::disk('public')->delete('admin/' . $product->img_product);
        }
    
        $product->delete();
    
        if ($product) {
            session()->flash('status', 'success');
            session()->flash('message', 'Berhasil hapus produk');
        }
    
        return redirect('/produk');
    }
}
