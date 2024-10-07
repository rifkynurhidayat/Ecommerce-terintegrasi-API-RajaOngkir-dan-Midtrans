<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::with('product')->get();
        return view('admin.categories.categories', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.categories-add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'unique:categories|required',
        ]);
        
            $categories = new Categories;
            $categories->category_name = $request->category_name;
            $categories->save();
    
            if ($categories) {
                Session::flash('status', 'success');
                Session::flash('message', 'Berhasil menambahkan data kategori');
            }
         else {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menambahkan data kategori. File gambar tidak sesuai.');
         }
        return redirect('/kategori');
    }


    public function edit($id){
        $categories = Categories::findOrFail($id);
        return view('admin.categories.categories-edit', ['categories' => $categories]);
    }

    public function update(Request $request, $id){
        $categories = Categories::FindOrFail($id);

        $validated = $request->validate([
            'category_name' => 'required',
        ]);

                $categories->category_name = $request->category_name;
                $categories->save();

                if ($categories) {
                    Session::flash('status', 'success');
                    Session::flash('message', 'Berhasil edit kategori');
                }
            else {
                Session::flash('status', 'error');
                Session::flash('message', 'gagal update data kategori');
            }
        return redirect('/kategori');
    }

    public function delete($id){
        $categories = Categories::findOrFail($id);

        $categories->delete();
    
        if ($categories) {
            session()->flash('status', 'success');
            session()->flash('message', 'Berhasil hapus produk');
        }

        return redirect('/kategori');
    }

}
