<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JijiWear - Fashion Terbaik')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    @stack('head')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                JIJI<span>WEAR</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} " href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }} " href="{{ route('products.index') }}">Produk</a>
                    </li>
                    @foreach (\App\Models\Category::take(4)->get() as $cat)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index', ['catogory' => $cat->slug]) }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item">
                        <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                            <input class="form-control form-control-sm me-1 navbar-search-input" type="search" name="search" placeholder="Cari Produk..." value="{{ request('search') }}">
                            <button class="btn-navbar-search" type="submit">
                                <i class="bi bi-search fs-6"></i>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-bag fs-5"></i>
                            @php
                            $cartCount = count(session()->get('cart', []));
                            @endphp
                            @if ($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="bi bi-box me-2"></i>Pesanan Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn-nav-login" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @yield('content')
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>JijiWear</h5>
                    <p style="font-size: 0.9rem;">Platform fashion terpercaya dengan koleksi baju berkualitas tinggi. 
                        Belanja nyaman, pengiriman cepat.</p>
                </div>
                <div class="col-md-2">
                    <h5>Kategori</h5>
                    @foreach (\App\Models\Category::all() as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
                <div class="col-md-3">
                    <h5>Layanan</h5>
                    <a href="#">Tentang Kami</a>
                    <a href="#">Cara Belanja</a>
                    <a href="#">Kebijakan Pengembalian</a>
                    <a href="#">Hubungi Kami</a>
                </div>
                <div class="col-md-3">
                    <h5>Pembayaran</h5>
                    <p style="font-size: 0.85rem;">Kami menerima berbagai metode pembayaran melalui Midtrans:</p>
                    <div class="d-flex gap-2 flex-wrap mt-2">
                        @foreach (['BCA', 'Mandiri', 'GoPay', 'OVO', 'Dana', 'QRIS', 'Kartu Kredit'] as $method)
                            <span class="badge footer-payment">{{ $method }}</span>                       
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} JijiWear &mdash; Demo untuk tugas kuliah
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>