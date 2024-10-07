@props(['title', 'detail_link'])

<div class="trend__content">
  <div class="section-title">
    <h4><a href="{{ $detail_link }}" class="text-dark">{{ $title }}</a></h4>
  </div>
  @foreach ($products as $pro)
    <div class="trend__item">
      <div class="trend__item__pic w-25">
        <img src="{{ asset('storage/admin/' . $pro->image(1)) }}" alt="{{ $pro->product_name }}">
      </div>
      <div class="trend__item__text">
        <h6>{{ $pro->product_name }}</h6>
        <div class="rating">
          @for ($i = 0; $i < $pro->filledStars(); $i++)
            <i class="fa fa-star"></i>
          @endfor
          @for ($i = 0; $i < $pro->emptyStars(); $i++)
            <i class="fa fa-star-o"></i>
          @endfor
          &nbsp;<h6 style="display: inline">{{ $pro->formatedAvgRating }}</h6>
        </div>
        <div class="product__price">Rp. {{ number_format($pro->product_price, 0, ',', '.') }}</div>
        <a href="/produk-detail/{{ $pro->id }}" class="btn btn-sm btn-primary">Beli</a>
      </div>
    </div>
  @endforeach
</div>
