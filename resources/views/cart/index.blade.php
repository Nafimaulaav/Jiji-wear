@extends('layouts.app')

@section('title', 'Keranjang Belanja - JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="cart-section">
    <div class="container">
        <h1 class="cart-page-title">
            <i class="bi bi-bag"></i>Keranjang Belanja
        </h1>
        @if (count($cart) > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <table class="cart-table table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $key => $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="cart-item-img" onerror="this.src='https://via.placeholder.com/70x70/1a1a2e/c9a84c?text=IMG'">
                                        <div>
                                            <div class="cart-item-name">{{ $item['name'] }}</div>
                                            <div class="cart-item-meta">
                                                <span class="cart-meta-badge">{{ $item['size'] }}</span>
                                                <span class="cart-meta-badge">{{ $item['color'] }}</span>
                                            </div>
                                            <div class="cart-item-unit-price">
                                                Rp {{ number_format($item['price'], 0,',','.') }} / pcs
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-qty-wrapper">
                                        <form action="{{ route('cart.update', $key) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" class="cart-qty-btn">-</button>
                                        </form>
                                        <span class="cart-qty-value">{{ $item['quantity'] }}</span>
                                        <form action="{{ route('cart.update', $key) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="cart-qty-btn">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="cart-item-subtotal">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0,',','.') }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cart-remove">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cart-actions">
                        <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-clear-cart">
                                <i class="bi bi-arrow-left"></i>Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-card-title">
                        Rincian Pesanan
                        </div>
                        <div class="summary-row">
                            <span class="label">Subtotal ({{ count($cart) }} item)</span>
                            <span>Rp {{ number_format($total, 0,',','.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Ongkos Kirim</span>
                            <span>Rp 15.000</span>
                        </div>                        
                        <div class="summary-total-row">
                            <span>Total</span>
                            <span class="amount">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                        </div>
                        @auth
                            <a href="{{ route('checkout.index') }}" class="btn-checkout">
                                <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                            </a>
                        @else
                            <div class="login-required-box">
                                <p>
                                    <i class="bi bi-lock me-1"></i>Login diperlukan untuk checkout
                                </p>
                                <a href="{{ route('login') }}" class="btn-login-to-checkout">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Login untuk Checkout
                                </a>
                            </div>
                        @endauth
                        <div class="summary-security-note">
                            <i class="bi bi-shield-lock"></i>
                            <span>Pembayaran 100% aman</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <div class="empty-cart">
            <span class="empty-icon">🛍️</span>
            <h3>Keranjang Masih Kosong</h3>
            <p>Yuk, mulai belanja dan temukan produk favoritmu!</p>
            <a href="{{ route('products.index') }}" class="btn-start-shopping">
                <i class="bi bi-bag"></i>Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
