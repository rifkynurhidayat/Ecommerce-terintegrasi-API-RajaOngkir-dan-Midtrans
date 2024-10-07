@extends('admin.layouts.home')
@section('title', 'produk')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 ">Produk </h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <a href="/produk-add" class="m-0 font-weight-bold text-primary text-decoration-none">Tambah Produk</a>
      </div>
      @if (Session::has('status'))
        <div class="alert alert-primary " role="alert">
          {{ Session::get('message') }}
        </div>
      @endif
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Product Name</th>
                <th>Product Category</th>
                <th>Product Price</th>
                <th>Stock S</th>
                <th>Stock M</th>
                <th>Stock L</th>
                <th>Stock XL</th>
                <th>Weight</th>
                <th>Description</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($produk as $pro)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $pro->product_name }}</td>
                  <td>{{ $pro->categories->category_name }}</td>
                  <td>Rp {{ number_format($pro->product_price) }}</td>
                  <td>{{ $pro->stock_s }}</td>
                  <td>{{ $pro->stock_m }}</td>
                  <td>{{ $pro->stock_l }}</td>
                  <td>{{ $pro->stock_xl }}</td>
                  <td>{{ $pro->weight }} gram</td>
                  <td>{{ $pro->description }}</td>
                  <td>
                    @if ($pro->img_product)
                      @php
                        $imageArray = explode(',', $pro->img_product);
                      @endphp

                      @foreach ($imageArray as $image)
                      <img width="70px" src="{{ asset('storage/admin/' . $image) }}" alt="">
                      @endforeach
                    @endif
                  </td>

                  <td>
                    <a href="produk-edit/{{ $pro->id }}" class="m-0 font-weight-bold text-primary">Edit</a>
                    <a href="produk-delete/{{ $pro->id }}"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                      class="m-0 font-weight-bold text-danger">Hapus</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
