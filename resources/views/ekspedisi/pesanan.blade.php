@extends('admin.layouts.eksepedisiHome')
@section('title', 'Ekspedisi')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-center text-gray-800 ">Pesanan </h1>
        {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                    For more information about DataTables, please visit the <a target="_blank"
                        href="https://datatables.net">official DataTables documentation</a>.</p> --}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                                <th>Nama Pelanggan</th>
                                <th>Nama Produk</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Harga Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ekspedisi as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user->name }}</td>
                                @foreach ($data->order_items as $pro)
                                <td>{{ $pro->product->product_name }}</td>
                                @endforeach
                                <td>{{ $data->order_date }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->status_pesanan }}</td>
                                <td>Rp. {{ number_format($data->total_price ) }}</td>
                                <td>
                                    <a href="/ekspedisi-resi/{{ $data->id }}" class="m-0 font-weight-bold text-primary">Input Resi</a>
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
