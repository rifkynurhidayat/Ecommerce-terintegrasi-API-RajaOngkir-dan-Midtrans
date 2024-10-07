@extends('admin.layouts.home')
@section('title', 'admin-order')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-center text-gray-800 ">Order </h1>
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
                            <th>No Order</th>
                            <th>Pelanggan</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Tanggal Pesanan</th>
                            <th>Ukuran</th>
                            <th>Qty</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $orderNumber = 1;
                            $ordersProcessed = [];
                        @endphp
                        @foreach ($orderItems as $item)
                            @if (!in_array($item->order->id, $ordersProcessed))
                                @php
                                    $ordersProcessed[] = $item->order->id;
                                @endphp
                                <tr>
                                    <td>{{ $orderNumber++ }}</td>
                                    <td>#{{ $item->order->id }}</td>
                                    <td>{{ $item->order->user->name }}</td>
                                    <td>
                                        @foreach ($item->order->order_items as $orderItem)
                                            {{ $orderItem->product->product_name }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($item->order->order_items as $orderItem)
                                            Rp {{ number_format($orderItem->product->product_price) }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $item->order->order_date }}</td>
                                    <td>
                                        @foreach ($item->order->order_items as $orderItem)
                                            {{ $orderItem->size }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($item->order->order_items as $orderItem)
                                            {{ $orderItem->qty }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $item->order->status }}</td>
                                    <td>{{ $item->order->status_pesanan }}</td>
                                    <td>
                                        Rp {{ number_format($item->order->order_items->sum(fn($orderItem) => $orderItem->product->product_price * $orderItem->qty)) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection
