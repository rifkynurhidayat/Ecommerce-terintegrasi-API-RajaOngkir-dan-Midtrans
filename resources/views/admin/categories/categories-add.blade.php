@extends('admin.layouts.home')
@section('title', 'categories-add')
@section('content')
  <div class="container-fluid">
    <form action="kategori" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <h2 class="mb-4 text-center">Tambah Kategori</h2>
        <label for="category_name" class="form-label ">Nama kategori</label>
        <input type="text" class="form-control col-8 @error('category_name') is-invalid @enderror" id="category_name"
          name="category_name">
      </div>
      @error('category_name')
        <div class="alert alert-danger col-8">{{ 'kategori sudah ada' }}</div>
      @enderror
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
@endsection
