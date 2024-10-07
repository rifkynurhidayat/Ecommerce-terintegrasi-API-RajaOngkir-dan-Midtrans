@extends('admin.layouts.home')
@section('title', 'transaksi')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 ">Setting Diskon Ongkir </h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Setting</h6>
      </div>
      <div class="card-body">
        <form action="" method="POST">
          @csrf
          <div class="form-group">
            <label for="min_trx" class="form-label">Minimal Transaksi (Rp.)</label>
            <input type="number" min="1" class="form-control @error('min_trx') is-invalid @enderror"
              id="min_trx" name="min_trx" required value="{{ $setting['min_trx'] }}">
            @error('min_trx')
              <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
          <button class="btn btn-primary btn-block">Simpan</button>
        </form>
      </div>
    </div>
  </div>
@endsection
