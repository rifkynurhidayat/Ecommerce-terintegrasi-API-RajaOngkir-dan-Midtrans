<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teras Factory | @yield('title')</title>

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('css/user.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}" type="text/css">
    <script src="{{ asset('js/header.js') }}"></script>
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
            <a href="./index.html"><img src="{{ asset('user/img/logo.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    @include('users.layouts.header')
    <!-- Header Section End -->



    <div class="container">
        @yield('content')
    </div>

    {{-- <!-- Categories Section Begin -->
        @include('users.layouts.categories-section')
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    @include('users.layouts.product-section')
    <!-- Product Section End -->

    <!-- Banner Section Begin -->
    @include('users.layouts.banner-section')
    <!-- Banner Section End -->

    <!-- Trend Section Begin -->
    @include('users.layouts.trend-section')
    <!-- Trend Section End -->

    <!-- Discount Section Begin -->
    @include('users.layouts.discount-section')
    <!-- Discount Section End -->

    <!-- Services Section Begin -->
    @include('users.layouts.service-section')
    <!-- Services Section End -->

    <!-- Instagram Begin -->
    @include('users.layouts.instagram-section')
    <!-- Instagram End --> --}}

    <!-- Footer Section Begin -->
    @include('users.layouts.footer-section')
    <!-- Footer Section End -->





    <!-- Js Plugins -->

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

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>

</html>
