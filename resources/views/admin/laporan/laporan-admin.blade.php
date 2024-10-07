@extends('admin.layouts.home')
@section('title', 'laporan')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-center text-gray-800 ">Laporan</h1>
        {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ url('/export-pdf') }}?tglAwal={{ request('tglAwal') }}&tglAkhir={{ request('tglAkhir') }}"
                    class="btn btn-success mt-3">Cetak Laporan</a>
                <div class="me-5 mt-3 col-md-6">
                    <form action="/laporan-admin" method="GET">
                        <label for="start_date">Tanggal Awal</label>
                        <input type="date" id="start_date" value="" name="tglAwal"
                            class="form-control datepicker-input">
                        <label for="end_date" class="mt-3">Tanggal Akhir</label>
                        <input type="date" id="end_date" value="" name="tglAkhir"
                            class="form-control datepicker-input">
                        <button type="submit" class="btn btn-primary mt-3">Filter</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Produk</th>
                                <th>Ukuran</th>
                                <th>QTY</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $trans)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trans->user->name }}</td>
                                    <td>
                                        @foreach ($trans->order_items as $item)
                                            {{ $item->product->product_name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($trans->order_items as $item)
                                            {{ $item->size }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($trans->order_items as $item)
                                            {{ $item->qty }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $trans->transaction->transaction_date }}
                                    </td>
                                    <td>Rp.{{ number_format($trans->transaction->total_payment) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-end"><strong>Total pendapatan:</strong></td>
                                <td><strong>Rp.{{ number_format($transaksi->sum('transaction.total_payment')) }}</strong></td>

                            </tr>
                        </tbody>
                    </table>
                                      
                </div>
            </div>
        </div>
    </div>


@endsection
