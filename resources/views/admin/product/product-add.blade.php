@extends('admin.layouts.home')
@section('title', 'product-add')
@section('content')

  <div class="container-fluid">

    <form action="produk" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <h2 class="mb-4 text-center">Tambah Produk</h2>
        <label for="category_name" class="form-label">Kategori Produk</label>
        <select name="categories_id" id="categories_id"
          class="form-control col-8  @error('categories_id') is-invalid @enderror">
          <option value="">Pilih kategori</option>
          @foreach ($category as $item)
            <option value="{{ $item->id }}">-{{ $item->category_name }}</option>
          @endforeach
        </select>
      </div>
      @error('categories_id')
        <div class="alert alert-danger col-8">{{ 'kategori belum diisi' }}</div>
      @enderror
      <div class="mb-3">
        <label for="product_name" class="form-label ">Nama Produk</label>
        <input type="text" class="form-control col-8  @error('product_name') is-invalid @enderror" id="product_name"
          name="product_name">
      </div>
      @if ($errors->has('product_name'))
      <div class="alert alert-danger col-8">{{ $errors->first('product_name') }}</div>
  @endif
      <div class="mb-3">
        <label for="product_price" class="form-label ">Harga Produk</label>
        <input type="number" class="form-control col-8  @error('product_price') is-invalid @enderror" id="product_price"
          name="product_price">
      </div>
      @error('product_price')
        <div class="alert alert-danger col-8">{{ 'harga produk belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="stock_s" class="form-label ">Stock S</label>
        <input type="number" class="form-control col-8 @error('stock_s') is-invalid @enderror" id="stock_s"
          name="stock_s">
      </div>
      @error('stock_s')
        <div class="alert alert-danger col-8">{{ 'produk stok belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="stock_m" class="form-label ">Stock M</label>
        <input type="number" class="form-control col-8 @error('stock_m') is-invalid @enderror" id="stock_m"
          name="stock_m">
      </div>
      @error('stock_m')
        <div class="alert alert-danger col-8">{{ 'produk stok belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="stock_l" class="form-label ">Stock L</label>
        <input type="number" class="form-control col-8 @error('stock_l') is-invalid @enderror" id="stock_l"
          name="stock_l">
      </div>
      @error('stock_l')
        <div class="alert alert-danger col-8">{{ 'produk stok belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="stock_xl" class="form-label ">Stock XL</label>
        <input type="number" class="form-control col-8 @error('stock_xl') is-invalid @enderror" id="stock_xl"
          name="stock_xl">
      </div>
      @error('stock_xl')
        <div class="alert alert-danger col-8">{{ 'produk stok belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="weight" class="form-label ">Weight</label>
        <input type="number" class="form-control col-8 @error('weight') is-invalid @enderror" id="weight"
          name="weight" placeholder="gram">
        <div id="weight" class="form-text">Berat dalam gram.</div>
      </div>
      @error('weight')
        <div class="alert alert-danger col-8">{{ 'Berat produk belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="description" class="form-label ">Description</label>
        <textarea class="form-control col-8  @error('description') is-invalid @enderror" id="description" name="description"
          rows="4"></textarea>
      </div>
      @error('description')
        <div class="alert alert-danger col-8">{{ 'deskripsi belum diisi' }}</div>
      @enderror

      <div class="mb-3">
        <label for="img_product" class="form-label">Foto Produk</label>
        <input class="form-control col-8 @error('img_product') is-invalid @enderror" type="file" id="img_product" name="img_product[]" multiple>
        <div id="img_product" class="form-text mx-4">Harus mengunggah tepat 4 foto produk.</div>
    
        @error('img_product[]')
            <div class="alert alert-danger col-8">{{ $message }}</div>
        @enderror
    </div>    
      <button type="submit" class="btn btn-primary">Tambah Produk</button>
    </form>
  </div>
@endsection
