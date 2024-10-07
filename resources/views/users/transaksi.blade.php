@extends('users.layouts.index')
@section('title', 'transaksi')
@section('content')
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" width="100px" alt="Admin"
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
                    @foreach ($transaksi as $trans)
                        @php
                            $ord = $trans->order;
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <p class="card-text">Status: {{ $ord->status }}</p>
                                                <p class="card-text badge badge-primary badge-pill">Status Pesanan:
                                                    {{ $ord->status_pesanan }}</p></br>
                                                <p class="card-text badge badge-primary badge-pill">Nomor resi:
                                                    {{ $ord->resi }}</p>
                                                <p class="card-text">Nomor Transaksi: {{ $ord->id }}</p>
                                                <p class="card-text">Produk:
                                                <ul class="list-group">
                                                    @foreach ($ord->order_items as $order_item)
                                                        @php
                                                            $pro = $order_item->product;
                                                        @endphp
                                                        <li class="list-group-item">
                                                            {{ $pro->product_name }}
                                                            @if ($order_item->testimoni)
                                                                @for ($i = 0; $i < $order_item->testimoni->rating; $i++)
                                                                    <i class="fa fa-star" style="color: yellow;"></i>
                                                                @endfor

                                                                @for ($i = 0; $i < 5 - $order_item->testimoni->rating; $i++)
                                                                    <i class="fa fa-star-o"></i>
                                                                @endfor
                                                            @else
                                                                <button type="button"
                                                                    class="btn badge badge-primary badge-pill testimoniBtn"
                                                                    data-order-item-id="{{ $order_item->id }}"
                                                                    data-pro-name="{{ $pro->product_name }}"
                                                                    data-toggle="modal" data-target="#testimoniModal">
                                                                    Testimoni
                                                                </button>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                </p>
                                                <p class="card-text">Jumlah: {{ $order_item->qty }}</p>
                                                <p class="card-text">Total Pembayaran: Rp.
                                                    {{ number_format($trans->total_payment) }}</p>
                                                <p class="card-text">Tanggal Transaksi: {{ $trans->transaction_date }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="testimoniModal" tabindex="-1" aria-labelledby="testimoniModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimoniModalLabel">
                        Testimoni untuk <span id="testi-pro-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir testimoni -->
                    <form method="post" action="/testimoni/" id="testi-form">
                        @csrf
                        <div class="form-group">
                            <label for="testimoniTextarea">Testimoni Anda</label>
                            <textarea class="form-control" id="testimoniTextarea" name="testimoni" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Rating</label>
                            <div class="rating-css">
                                <div class="star-icon">
                                    <input type="radio" value="1" name="rating" checked id="rating1">
                                    <label for="rating1" class="fa fa-star"></label>
                                    <input type="radio" value="2" name="rating" id="rating2">
                                    <label for="rating2" class="fa fa-star"></label>
                                    <input type="radio" value="3" name="rating" id="rating3">
                                    <label for="rating3" class="fa fa-star"></label>
                                    <input type="radio" value="4" name="rating" id="rating4">
                                    <label for="rating4" class="fa fa-star"></label>
                                    <input type="radio" value="5" name="rating" id="rating5">
                                    <label for="rating5" class="fa fa-star"></label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#testimoniModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget) // Button that triggered the modal
            let modal = $(this);

            let pro_name = button.data('pro-name');
            let form_testi_action = '/testimoni/' + button.data('order-item-id');

            modal.find('#testi-pro-name').text(pro_name);
            modal.find('#testi-form').attr('action', form_testi_action);
        });
    </script>
@endsection
