@extends('users.layouts.index')
@section('title', 'keranjang')
@section('content')
  <!-- Breadcrumb Begin -->
  <div class="breadcrumb-option">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumb__links">
            <a href="/home"><i class="fa fa-home"></i> Home</a>
            <span>Keranjang Belanja</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Breadcrumb End -->
  <section class="shop-cart spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          @php $increment = 0 @endphp
          <div class="shop__cart__table" data-aos="fade-up" data-aos-delay="{{ $increment += 100 }}">
            <table>
              <thead>
                <tr>
                  <th>Produk</th>
                  <th class="text-center">Harga</th>
                  <th class="text-center">Tambah kuantiti</th>
                </tr>
              </thead>
              @if (session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
              @endif
              @if (session('error'))
                <div class="alert alert-danger">
                  {{ session('error') }}
                </div>
              @endif

              <tbody>
                @foreach ($order_item as $item)
                  <tr>
                    <td class="cart__product__item">
                      @if ($item->product->img_product)
                        @php
                          $imageArray = explode(',', $item->product->img_product);
                        @endphp
                        @if (isset($imageArray[1]))
                          <img width="90px" src="{{ asset('storage/admin/' . $imageArray[3]) }}" alt="Product Image">
                        @endif
                      @endif
                      <div class="cart__product__item__title">
                        <h6>{{ $item->product->product_name }}</h6>
                      </div>
                      <span class="">Yang dibeli : {{ $item->qty }}</span><br>
                      <span class="">Size : {{ $item->size }}</span>
                      <span class="mx-4">weight : {{ $item->product->weight }} gram</span>
                    </td>
                    <td class="cart__price text-center">
                      Rp.{{ number_format($item->product->product_price) }}
                    </td>
                    <td>
                      <form action="/update-order/{{ $item->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="quantity">
                          <div class="pro-qty">
                            <input type="number" name="qty" value="0"">
                          </div>
                        </div>
                    <td><button type="submit" class="btn btn-sm btn-primary cancel-btn"
                        data-id="{{ $item->id }}">Update</button>
                    </td>
                    </form>
                    </td>
                    <form action="/batal-order/{{ $item->id }}" method="post">
                      @csrf
                      @method('DELETE')
                      <td><button type="submit" class="btn btn-sm btn-danger cancel-btn"
                          data-id="{{ $item->id }}">Batal</button></td>
                    </form>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <span class="mx-4 fw-bold">Berat : {{ $order->total_weight }} gram</span>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 mt-5">
          <div class="cart__btn">
            <a href="/home">Tambah produk?</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="cart__total__procced col-lg-10">
          <h6>Total yang harus dibayarkan :</h6>
          <ul>
            <li>Total
              <span id="total" name="total">Rp.{{ number_format($order->total_price) }}</span>
            </li>
            @if (isset($diskon_ongkir) && ($diskon_ongkir == true))
              <li>
                <div class="alert alert-success">
                  Anda berhak mendapatkan diskon ongkir. <br>
                  Anda bisa memasangnya ketika checkout.
                </div>
              </li>
            @endif
          </ul>
          <a class="btn btn-primary mt-2" href="/checkout/{{ $order->id }}">Bayar</a>
          </form>
        </div>
      </div>
    </div>
  </section>


@endsection
