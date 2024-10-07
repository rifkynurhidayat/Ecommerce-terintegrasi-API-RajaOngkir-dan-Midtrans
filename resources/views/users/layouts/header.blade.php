<header class="header">
    <div class="container">
        
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
                            <div class="user-dropdown">
                                <span id="user-dropdown">Welcome, {{ Auth::user()->name }}</span>
                                <div class="user-menu" id="user-menu">
                                    <a href="/profil">Profil</a>
                                    <a href="/logout">Log out</a>
                                </div>
                            </div>
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
                                        $query->select('id')
                                              ->from('orders')
                                              ->where('user_id', Auth::user()->id)
                                              ->where('status', 'pending'); // Filter orders by status "pending"
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
