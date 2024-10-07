@extends('users.layouts.index')
@section('title', 'pesanan')
@section('content')
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/' . $user->foto) }}" width="100px" alt="Admin"
                                    class="rounded-circle" width="150">
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="/transaksi-user" class="mb-0 text-decoration-none">Transaksi</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="/pesanan-user" class="mb-0 text-decoration-none">Order</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="/profil" class="mb-0 text-decoration-none">Profil</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($pesanan as $pesan)
                                    <div class="col-md-12">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <p class="card-text">Nomor Order: {{ $pesan->id }}</p>
                                                <p class="card-text">Order Date: {{ $pesan->order_date }}</p>
                                                <p class="card-text">Status: {{ $pesan->status }}</p>
                                                <p class="card-text">Total Weight: {{ $pesan->total_weight }}</p>
                                                <p class="card-text">Jumlah Bayar: Rp.{{ number_format($pesan->total_price) }}</p>
                                                @foreach ($pesan->order_items as $order_item)
                                                    <p class="card-text">Produk: {{ $order_item->product->product_name }}</p>
                                                    <p class="card-text">Jumlah: {{ $order_item->qty }}</p>
                                                @endforeach
                                                @if ($pesan->status == 'pending')
                                                    <a href="/checkout/{{ $pesan->id }}" class="btn btn-primary">Bayar</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
