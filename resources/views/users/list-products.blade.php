@extends('users.layouts.index')
@section('title', $title)
@section('content')
  <section class="product spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="section-title">
            <h4>{{ $title }}</h4>
          </div>
        </div>
      </div>
      <div class="row property__gallery">
        @foreach ($products as $pro)
          <div class="col-lg-3 col-md-4 col-sm-6 mix category-{{ $pro->categories->id }}">
            <div class="card">
              <div class="card-body d-flex flex-column justify-content-between">
                  @if ($pro->img_product)
                      @php
                          $imageArray = explode(',', $pro->img_product);
                      @endphp
                      @if (isset($imageArray[3]))
                          <div class="image-container position-relative overflow-hidden" style="height: 200px;">
                              <img src="{{ asset('storage/admin/' . $imageArray[3]) }}" alt="Product Image" class="img-fluid product-image position-absolute" style="height: 100%; width: auto;">
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
  </section>
@endsection
