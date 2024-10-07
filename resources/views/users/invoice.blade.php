@extends('users.layouts.index')
@section('title', 'invoice')
@section('content')
<div class="container">
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">Invoice #{{ $transaction->id }} <span class="badge bg-success font-size-12 ms-2">{{ $transaction->order->status }}</span></h4>
                            <div class="mb-4">
                               <h2 class="mb-1 text-muted">Teras Factory Outlet</h2>
                            </div>
                        </div>
    
                        <hr class="my-4">
    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2">{{ $transaction->order->user->name }} </h5>
                                    <p class="mb-1">{{ $transaction->kode_pos }} {{ $transaction->province  }} {{ $transaction->city_name  }}</p>
                                    <p class="mb-1">{{ $transaction->order->user->email }}</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    {{-- <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p>#DZ0112</p>
                                    </div> --}}
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Tanggal faktur</h5>
                                        <p>{{ $transaction->transaction_date }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order No:</h5>
                                        <p>{{ $transaction->order->id }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                        <div class="py-2">
                            <h5 class="font-size-15">Detail pesanan</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Harga</th>
                                            <th>Kuantiti</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @foreach ($transaction->order->order_items as $order_item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1">{{  $order_item->product->product_name }}</h5>
                                                    <p class="text-muted mb-0">Size : {{ $order_item->size }}</p>
                                                </div>
                                            </td>
                                            <td>Rp. {{ number_format($order_item->product->product_price) }}</td>
                                            <td>{{ $order_item->qty }}</td>
                                            <td class="text-end">Rp. {{ number_format($order_item->total_items)  }}</td>
                                        </tr>
                                        @endforeach
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                            <td class="text-end">Rp.{{ number_format($transaction->order->total_price)  }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end">Rp. {{ number_format($transaction->discount)  }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Ongkos Kirim :</th>
                                            <td class="border-0 text-end">{{ $transaction->service }} : Rp. {{ number_format($transaction->ongkir)  }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end"><h4 class="m-0 fw-semibold">Rp.{{ number_format($transaction->total_payment)  }}</h4></td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

@endsection