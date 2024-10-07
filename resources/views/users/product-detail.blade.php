@extends('users.layouts.index')
@section('title', 'product-detail')
@section('content')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/home"><i class="fa fa-home"></i>Home</a>
                        <a href="">{{ $detail->categories->category_name }}</a>
                        <span>{{ $detail->product_name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            @if ($detail->img_product)
                                @php
                                    $imageArray = explode(',', $detail->img_product);
                                @endphp
                                @for ($i = 0; $i < min(4, count($imageArray)); $i++)
                                    <a class="pt @if ($i === 0) active @endif"
                                        href="-{{ $i + 1 }}">
                                        <img src="{{ asset('storage/admin/' . $imageArray[$i]) }}" alt="">
                                    </a>
                                @endfor
                            @endif
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @if ($detail->img_product)
                                    @for ($i = 0; $i < min(4, count($imageArray)); $i++)
                                        <img data-hash="product-{{ $i + 1 }}" class="product__big__img"
                                            src="{{ asset('storage/admin/' . $imageArray[$i]) }}" alt="">
                                    @endfor
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="/order/{{ $detail->id }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_size" id="selected_size" value="">
                            <h3>{{ $detail->product_name }}</h3>
                                @php
                                $totalRating = 0;
                                $totalTestimonies = $detail->testimoni->count();
                            
                                // Mengakumulasi total rating dari semua testimoni
                                foreach ($detail->testimoni as $testi) {
                                    $totalRating += $testi->rating;
                                }
                                // Menghitung rata-rata rating
                                $averageRating = $totalTestimonies > 0 ? $totalRating / $totalTestimonies : 0;
                            
                                // Mengkonversi rating rata-rata menjadi jumlah bintang yang diisi
                                $filledStars = min(5, max(0, round($averageRating))); 
                                // Menghitung jumlah bintang kosong
                                $emptyStars = 5 - $filledStars; 
                            @endphp
                            
                            <div class="rating">
                                @for ($i = 0; $i < $filledStars; $i++)
                                    <i class="fa fa-star" style="color: yellow;"></i>
                                @endfor
                            
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="fa fa-star-o"></i>
                                @endfor
                       
                                <span>({{ $totalTestimonies }} reviews )</span><br>
                        
                                <span>Berat:  {{ $detail->weight }} gram</span>
                            </div>
                            <div class="product__details__price">Rp.{{ number_format($detail->product_price) }}</div>
                            <p>{{ $detail->description }}</p>
                            <div class="product__details__widget mt-5">
                                <ul class="list-unstyled ">
                                    <li>
                                        <label class="font-weight-bold">Pilih Ukuran:</label>
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-outline-primary active">
                                                <input type="radio" name="size" id="xs-btn" value="s"
                                                    autocomplete="off" checked>
                                                s : {{ $detail->stock_s }}
                                            </label>
                                            <label class="btn btn-outline-primary">
                                                <input type="radio" name="size" id="s-btn" value="m"
                                                    autocomplete="off">
                                                m : {{ $detail->stock_m }}
                                            </label>
                                            <label class="btn btn-outline-primary">
                                                <input type="radio" name="size" id="m-btn" value="l"
                                                    autocomplete="off">
                                                l : {{ $detail->stock_l }}
                                            </label>
                                            <label class="btn btn-outline-primary">
                                                <input type="radio" name="size" id="l-btn" value="xl"
                                                    autocomplete="off">
                                                xl : {{ $detail->stock_xl }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="cart__quantity mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <label for="qty" class="font-weight-bold">Jumlah yang dibeli:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" value="1" name="qty" id="qty"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="cart-btn btn-primary mt-4"><span class="icon_bag_alt"></span> Tambah ke keranjang</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Testimoni</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p>{{ $detail->description }}</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Testimoni</h6>
                                @foreach ($detail->testimoni as $testi)
                                <p>Testimoni dari: {{ $testi->user->name }}</p>
                                <p>{{ $testi->testimoni }}</p>
                            @endforeach
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                    <div class="row">
                        @php $increment = 0 @endphp
                        @foreach($kategoriSama as $product)
                            <div class="col-md-4">
                                <div class="card" data-aos="fade-up" data-aos-delay="{{ $increment += 100 }}">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        @if ($product->img_product)
                                            @php
                                                $imageArray = explode(',', $product->img_product);
                                            @endphp
                                            @if (isset($imageArray[3]))
                                                <div class="image-container position-relative overflow-hidden" style="height: 200px;">
                                                    <img src="{{ asset('storage/admin/' . $imageArray[3]) }}" alt="Product Image" class="img-fluid product-image position-absolute" style="height: 100%; width: auto;">
                                                </div>
                                            @endif
                                        @endif
                                        <h6 class="card-title mt-3">{{ $product->product_name }}</h6>
                                        <div class="rating">
                                            @for ($i = 0; $i < $product->filledStars(); $i++)
                                                <i class="fa fa-star" style="color: yellow;"></i>
                                            @endfor
                                            @for ($i = 0; $i < $product->emptyStars(); $i++)
                                                <i class="fa fa-star-o"></i>
                                            @endfor
                                            &nbsp;<span>{{ $product->formatedAvgRating }}</span>
                                            <div class="product__price mt-2">Rp.{{ number_format($product->product_price) }}</div>
                                        </div>
                                        <a class="btn btn-primary mt-2" href="/produk-detail/{{ $product->id }}">Beli</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
