@extends('users.layouts.index')
@section('title', 'home')
@section('content')
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="section-title">
                        <h4>Produk</h4>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">All</li>
                        @foreach ($category as $cat)
                            <li data-filter=".category-{{ $cat->id }}">{{ $cat->category_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row property__gallery">
                @php $increment = 0 @endphp
                @foreach ($produk as $pro)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix category-{{ $pro->categories->id }}">
                        <div class="card" data-aos="fade-up" data-aos-delay="{{ $increment +=100 }}">
                            <div class="card-body d-flex flex-column justify-content-between">
                                @if ($pro->img_product)
                                    @php
                                        $imageArray = explode(',', $pro->img_product);
                                    @endphp
                                    @if (isset($imageArray[3]))
                                        <div class="image-container position-relative overflow-hidden"
                                            style="height: 200px;">
                                            <img src="{{ asset('storage/admin/' . $imageArray[3]) }}" alt="Product Image"
                                                class="img-fluid product-image position-absolute"
                                                style="height: 100%; width: auto;">
                                        </div>
                                    @endif
                                @endif
                                <h6 class="card-title mt-3">{{ $pro->product_name }}</h6>
                                <div class="rating">
                                    @for ($i = 0; $i < $pro->filledStars(); $i++)
                                        <i class="fa fa-star" style="color: yellow;"></i>
                                    @endfor
                                    @for ($i = 0; $i < $pro->emptyStars(); $i++)
                                        <i class="fa fa-star-o"></i>
                                    @endfor
                                    &nbsp;<span>{{ $pro->formatedAvgRating }}</span>
                                    <div class="product__price mt-2">Rp.{{ number_format($pro->product_price) }}</div>
                                </div>
                                <a class="btn btn-primary mt-2" href="/produk-detail/{{ $pro->id }}">Beli</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </section>

    <section class="banner set-bg" data-setbg="{{ asset('user/img/banner/banner-2.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="banner__slider owl-carousel">
                        <div class="banner__item">
                            <div class="banner__text">
                                <h1>Teras Factory Outlet</h1>
                            </div>
                        </div>
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>Gratis Ongkir</span>
                                <h1>Minimal pembelian diatas RP. 300.000</h1>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>Nantikan promo diskon besar-besaran</span>
                                <h1>Teras Factory Oultet</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trend spad">
        <div class="container">
            <div class="row">
                @php $incrementUnggul = 0 @endphp
                <div class="col-lg-4 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $incrementUnggul += 100 }}">
                    <x-product-section title="Produk Unggulan"  :products="$unggulan" detail_link="/produk-unggulan" />
                </div>
                @if ($preferensi !== null)
                    <div class="col-lg-4 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $incrementUnggul += 200 }}">
                        <x-product-section title="Produk yang baru kamu beli" :products="$preferensi" detail_link="/produk-preferensi" />
                    </div>
                @elseif($ratingTinggi !== null)
                    <div class="col-lg-4 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $incrementUnggul += 300 }}">
                        <x-product-section title="Rating Tertinggi" :products="$ratingTinggi"
                            detail_link="/produk-rating-tertinggi" />
                    </div>
                @endif
                <div class="col-lg-4 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $incrementUnggul += 400 }}">
                    <x-product-section title="Sering Dilihat" :products="$seringDilihat" detail_link="/produk-sering-dilihat" />
                </div>
            </div>
        </div>
    </section>
@endsection
