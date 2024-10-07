@extends('admin.layouts.home')
@section('title', 'transaksi')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-center text-gray-800 ">Transaksi </h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Product</th>
                            <th>Tanggal transaksi</th>
                            <th>Ongkir</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    @foreach ($item->order_items as $order_item)
                                        {{ $order_item->product->product_name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @if($item->transaction)
                                    {{ $item->transaction->transaction_date }}
                                    @else 
                                        <h6> Belum melakukan pembayaran</h6>
                                    @endif
                                </td>
                                <td>
                                    @if($item->transaction)
                                    Rp. {{ number_format($item->transaction->ongkir) }}
                                    @else 
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($item->transaction)
                                    Rp. {{ number_format($item->transaction->discount) }}
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($item->transaction)
                                    Rp. {{ number_format($item->transaction->total_payment) }}
                                    @else 
                                    -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                
            </div>
        </div>
    @endsection
