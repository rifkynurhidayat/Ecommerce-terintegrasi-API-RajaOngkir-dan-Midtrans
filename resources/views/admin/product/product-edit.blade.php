@extends('admin.layouts.home')
@section('title', 'product-edit')
@section('content')
  <div class="container-fluid">
    <form action="/produk/{{ $product->id }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <h2 class="mb-4 text-center">Edit Produk</h2>
        <label for="category_name" class="form-label ">Kategori Produk</label>
        <select name="categories_id" id="categories_id" class="form-control  col-8">
          <option value="{{ $product->categories->id }}">{{ $product->categories->category_name }}</option>
          @foreach ($categories as $item)
            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="product_name" class="form-label ">Nama Produk</label>
        <input type="text" class="form-control col-8" id="product_name" name="product_name"
          value="{{ $product->product_name }}" required>
      </div>
      <div class="mb-3">
        <label for="product_price" class="form-label ">Harga Produk</label>
        <input type="number" class="form-control col-8" id="product_price" value="{{ $product->product_price }}"
          name="product_price">
      </div>
      <div class="mb-3">
        <label for="stock_s" class="form-label ">Stock S</label>
        <input type="number" class="form-control col-8" id="stock_s" value="{{ $product->stock_s }}" name="stock_s">
      </div>
      <div class="mb-3">
        <label for="stock_m" class="form-label ">Stock M</label>
        <input type="number" class="form-control col-8" id="stock_m" value="{{ $product->stock_m }}" name="stock_m">
      </div>
      <div class="mb-3">
        <label for="stock_l" class="form-label ">Stock L</label>
        <input type="number" class="form-control col-8" id="stock_l" value="{{ $product->stock_l }}" name="stock_l">
      </div>
      <div class="mb-3">
        <label for="stock_xl" class="form-label ">Stock XL</label>
        <input type="number" class="form-control col-8" id="stock_xl" value="{{ $product->stock_xl }}" name="stock_xl">
      </div>
      <div class="mb-3">
        <label for="wieght" class="form-label ">Weight</label>
        <input type="number" class="form-control col-8" id="wieght" value="{{ $product->weight }}" name="wieght">
        <div id="weight" class="form-text">Berat dalam gram.</div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label ">Description</label>
        <textarea class="form-control col-8" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
      </div>
      <div class="mb-3">
        <label for="img_product" class="form-label">Foto Product</label>
        <input class="form-control col-8" type="file" id="img_product" name="img_product[]" multiple>
        <div id="img_product" class="form-text mx-4 mt-3">Foto harus 4 </div>

        @if (isset($product->img_product))
          @php
            $imageArray = explode(',', $product->img_product);
          @endphp

          @foreach ($imageArray as $image)
            <img width="150px" src="{{ asset('storage/admin/' . $image) }}" alt="Product Image" class="mt-2">
          @endforeach
        @endif
      </div>

      <button type="submit" class="btn btn-primary">Edit Produk</button>
    </form>
  </div>
@endsection
