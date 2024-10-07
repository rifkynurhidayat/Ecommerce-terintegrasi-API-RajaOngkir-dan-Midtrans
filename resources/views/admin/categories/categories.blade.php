@extends('admin.layouts.home')
@section('title', 'categories')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 ">Kategories </h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <a href="/kategori-add" class="m-0 font-weight-bold text-decoration-none text-primary">Tambah Kategori</a>
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
                <th>Product Category</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $cat)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $cat->category_name }}</td>
                  <td>
                    <a href="/kategori/{{ $cat->id }}"
                      class="m-0 font-weight-bold text-decoration-none text-primary">Edit</a>
                    <a href="/kategori-delete/{{ $cat->id }}"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                      class="m-0 font-weight-bold text-decoration-none text-danger">Hapus</a>
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
