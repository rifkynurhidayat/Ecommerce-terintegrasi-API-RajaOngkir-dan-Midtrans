<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <title>Teras | checkout</title>

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}" type="text/css">


</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <div class="offcanvas__logo">
            <a href="/home"><img src="{{ asset('user/img/logo.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>
    </div>
    <!-- Offcanvas Menu End -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="/home"><img src="{{ asset('storage/register/logo.png') }}" style="width: 65px; height: 65px; object-fit: contain;" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu text-center">
                        <ul>
                            <ul>
                                <li class="{{ request()->is('home') ? 'active' : '' }}"><a href="/home">Home</a></li>
                                <li class="{{ request()->is('profil') ? 'active' : '' }}"><a href="/profil-toko">Profil</a></li>
                            </ul>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            @if (Auth::check())
                                <span>Welcome, {{ Auth::user()->name }}</span>
                            @else
                                <a href="/login">Login</a>
                                <a href="/register">Register</a>
                            @endif
                        </div>
                        <ul class="header__right__widget">
                            <li><a href="/order"><span class="icon_bag_alt me-2"></span>
                                    <div class="tip">
                                        @if (Auth::check())
                                            {{ \App\Models\Order_items::whereIn('order_id', function ($query) {
                                                $query->select('id')->from('orders')->where('user_id', Auth::user()->id)->where('status', 'pending'); // Filter orders by status "pending"
                                            })->count() }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>


    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <form action="/transaction/{{ $co->id }}" method="post" class="checkout__form" id="form-checkout">
                <input type="hidden" name="user_id" value="{{ $co->user->id }}">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Detail Pembayaran</h5>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <span> Nama</span>
                                    <input type="text" value="{{ $co->user->name }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <span>Alamat</span>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ $co->user->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                <div class="checkout__form__input">
                                    <span>Email</span>
                                    <input type="text" value="{{ $co->user->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12  mt-3">
                                <div class="checkout__form__input">
                                    {{-- <label for="">Provinsi Asal</label> --}}
                                    <input type="hidden" value="9" name="provinsi_origin" id="provinsi_origin"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12  mt-3">
                                <div class="checkout__form__input">
                                    {{-- <label for="">Kota asal</label> --}}
                                    <input type="hidden" name="city_origin" id="city_origin" value="211"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3" @if (!$diskon_ongkir) style="display: none" @endif>
                                <div class="">
                                    <input type="checkbox" name="disc-ongkir" id="diskon_ongkir" value="1">
                                    <label for="diskon_ongkir">Pakai diskon ongkir</label>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div class="checkout__form__input">
                                    <span>Pilih Provinsi</span>
                                    <select name="provinsi_id" id="province_id" class="form-control">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($province as $provinsi)
                                            <option value="{{ $provinsi['province_id'] }}"
                                                namaprovinsi="{{ $provinsi['province'] }}"
                                                {{ isset($userProvinceId) && $userProvinceId == $provinsi['province_id'] ? 'selected' : '' }}>
                                                {{ $provinsi['province'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="checkout__form__input">
                                    <span>Pilih Kota</span>
                                    <select name="kota_id" id="kota_id" class="form-control">
                                        <option value="" namakota="">Pilih Kota</option>
                                        @if (isset($userCityId))
                                            <option value="{{ $userCityId }}" selected>{{ $co->user->city_name }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="checkout__form__input">
                                    <label for="">Pilih Ekspedisi</label>
                                    <select name="kurir" id="kurir" class="form-control">
                                        <option value="">Pilih Ekspedisi</option>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS</option>
                                        <option value="tiki">Tiki</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="checkout__form__input">
                                    <label for="">Pilih Layanan</label>
                                    <select name="layanan" id="layanan" class="form-control">
                                        <option value="">Pilih layanan</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Pesanan kamu</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Produk</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    @foreach ($co->order_items as $order_item)
                                        <li>
                                            {{ $order_item->product->product_name }}
                                            x {{ $order_item->qty }} <span>
                                                Rp. {{ number_format($order_item->total_items) }} </span>
                                        </li>
                                    @endforeach
                                    <div class="form-group ">
                                        <label>total berat (gram) </label>
                                        <input class="form-control" type="text" value="{{ $co->total_weight }}"
                                            name="weight" id="weight">
                                    </div>
                                    <div class="form-group ">
                                        <label>total ongkos kirim </label>
                                        <input class="form-control" type="text" id="ongkos_kirim"
                                            name="ongkos_kirim">
                                    </div>
                                    <li id="disc-ongkir-field" style="display: none">
                                        Diskon Ongkir <span id="disc-ongkir-val"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <label for="">Total Belanja</label>
                                    <input class="form-control" type="text" id="total_belanja"
                                        name="total_belanja" value="Rp. {{ number_format($co->total_price) }}">
                                </ul>

                                <ul>
                                    <label for="">Total keseluruhan</label>
                                    <input class="form-control" type="text" id="total" name="total"
                                        readonly>
                                </ul>
                            </div>
                            <button type="button" class="site-btn" id="pay-button">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="./index.html"><img src="{{ asset('storage/register/logo.png') }}"
                                    width="90px" alt=""></a>
                        </div>
                        <p>Teras Factoru Outlet menjual berbagai pakaian seperti pakaian anak, remaja, sampai dewasa.</p>
                            cilisis.</p>
                        <div class="footer__payment">
                            <a href="#"><img src="img/payment/payment-1.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-2.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-3.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-4.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-5.png" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="footer__widget">
                        <h6>Quick links</h6>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Blogs</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h6>Account</h6>
                        <ul>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Orders Tracking</a></li>
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">Wishlist</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-8">
                    <div class="footer__newslatter">
                        <h6>NEWSLETTER</h6>
                        <form action="#">
                            <input type="text" placeholder="Email">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <div class="footer__copyright__text">
                        <p>Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | Teras Factory Outlet<i class="fa fa-heart"
                                aria-hidden="true"></i>
                        </p>
                    </div>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </footer>

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    {{-- Modal payment --}}
    <div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id="modal-payment">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <div id="snap-container" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('user/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('user/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>

    <script>
        let dapat_diskon_onkir = {{ $diskon_ongkir ? 'true' : 'false' }};

        function punyaDiskonOngkir() {
            return $('#diskon_ongkir').is(':checked') && dapat_diskon_onkir;
        }

        $(document).ready(function() {
            let provinceId = "{{ isset($userProvinceId) ? $userProvinceId : '' }}";
            let cityId = "{{ isset($userCityId) ? $userCityId : '' }}";

            // Jika user memiliki provinsi, otomatis trigger untuk load kota
            if (provinceId) {
                $.ajax({
                    url: "/city/" + provinceId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="kota_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kota_id"]').append('<option value="' +
                                value.city_id + '"' + (cityId == value.city_id ?
                                    ' selected' : '') + '>' +
                                value.city_name + '</option>');
                        });
                    }
                });
            }

            $('select[name="provinsi_id"]').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: "/city/" + provinceId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="kota_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="kota_id"]').append('<option value="' +
                                    value.city_id + '">' + value.city_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="kota_id"]').empty();
                }
            });

            $('select[name="kurir"]').on('change', function() {
                let origin = $("input[name=city_origin]").val();
                let destination = $("select[name=kota_id]").val();
                let courier = $(this).val();
                let weight = $("input[name=weight]").val();

                if (courier) {
                    $.ajax({
                        url: "/origin=" + origin + "&destination=" + destination + "&weight=" +
                            weight + "&courier=" + courier,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="layanan"]').empty();
                            $.each(data, function(key, value) {
                                $.each(value.costs, function(key1, value1) {
                                    $.each(value1.cost, function(key2, value2) {
                                        $('select[name="layanan"]')
                                            .append('<option value="' +
                                                value1.service + '">' +
                                                value1
                                                .service + '-' + value1
                                                .description + '-' +
                                                value2.value +
                                                '</option>');
                                    });
                                });
                            });
                        }
                    });
                } else {
                    $('select[name="layanan"]').empty();
                }
            });

            $('select[name="layanan"]').on('change', function() {
                let selectedLayanan = $(this).val(); // Dapatkan nilai layanan yang dipilih

                // Dapatkan data ongkos kirim berdasarkan layanan yang dipilih
                let ongkosKirim = $(this).find('option:selected').text().split('-').pop().trim();

                let discOngkir = punyaDiskonOngkir() ? ongkosKirim * -1 : 0;

                if (dapat_diskon_onkir) {
                    $('#disc-ongkir-field').show();
                    $('#disc-ongkir-val').text('Rp. ' + formatRupiah(discOngkir))
                }

                // Tampilkan data ongkos kirim di suatu elemen, misalnya sebuah input
                $('input[name="ongkos_kirim"]').val(ongkosKirim);
            });

            $('select[name="layanan"]').on('change', function() {
                $('#pay-button').addClass('d-none');

                // Dapatkan nilai total belanja dari input
                let totalBelanja = parseInt($('input[name="total_belanja"]').val().replace(/\D/g, ''));

                // Dapatkan data ongkos kirim berdasarkan layanan yang dipilih
                let ongkosKirim = parseInt($(this).find('option:selected').text().split('-').pop().trim()
                    .replace(/\D/g, ''));

                let discOngkir = punyaDiskonOngkir() ? ongkosKirim * -1 : 0;

                // Hitung total keseluruhan
                let totalKeseluruhan = totalBelanja + ongkosKirim + discOngkir;

                // Tampilkan total keseluruhan di suatu elemen, misalnya sebuah input
                $('input[name="total"]').val('Rp. ' + formatRupiah(totalKeseluruhan));

                fetchSnapToken(() => {
                    $('#pay-button').removeClass('d-none');
                });
            });

            // Fungsi untuk mengubah format angka menjadi format mata uang Rupiah
            function formatRupiah(angka) {
                let reverse = angka.toString().split('').reverse().join('');
                let ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }

        });
    </script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        $(payButton).addClass('d-none');

        let snapToken = '';

        function fetchSnapToken(closure) {
            let form = document.getElementById('form-checkout');
            fetch("/transaction/getSnapToken/{{ $co->id }}" + (punyaDiskonOngkir() ? '?disc-ongkir=1' : ''), {
                    method: 'post',
                    body: new FormData(form),
                })
                .then(res => {
                    return res.json();
                })
                .then(res => {
                    snapToken = res.snapToken;
                    closure();
                });
        }

        payButton.addEventListener('click', function() {
            $('#modal-payment').modal('show');

            // Menampilkan popup pembayaran menggunakan Snap
            window.snap.embed(snapToken, {
                embedId: 'snap-container',
                onSuccess: function(result) {
                    /* Anda dapat menambahkan implementasi khusus di sini */
                    alert("Pembayaran berhasil!");

                    $('#modal-payment').modal('hide');

                    $('#form-checkout').submit();
                },
                onPending: function(result) {
                    /* Anda dapat menambahkan implementasi khusus di sini */
                    alert("Menunggu pembayaran!");

                    $('#modal-payment').modal('hide');
                },
                onError: function(result) {
                    /* Anda dapat menambahkan implementasi khusus di sini */
                    alert("Pembayaran gagal!");

                    $('#modal-payment').modal('hide');
                },
                onClose: function() {
                    /* Anda dapat menambahkan implementasi khusus di sini */
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');

                    $('#modal-payment').modal('hide');
                }
            });
        });
    </script>

</body>

</html>
