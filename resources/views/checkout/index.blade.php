@extends('layouts.app')

@section('title', 'Checkout - JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
    <div class="checkout-section">
        <div class="container">
            <h1 class="checkout-page-title">
                <i class="bi bi-bag-check"></i>Checkout
            </h1>
            <form action="{{ route('checkout.process') }}" method="POST" novalidate>
                @csrf
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="checkout-card">
                            <div class="checkout-section-header">
                                <i class="bi bi-geo-alt"></i>Alamat Pengiriman
                            </div>
                            @auth
                            <div class="checkout-user-info">
                                <i class="bi bi-person-circle"></i>
                                Dipesan oleh: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
                            </div>
                            @endauth
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="shipping_name">Nama Penerima</label>
                                    <input type="text" name="shipping_name" id="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror" value="{{old('shipping_name', Auth::user()->name ?? '') }}" required>
                                    @error('shipping_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="shipping_phone">Nomor Hp *</label>
                                    <input type="text" name="shipping_phone" id="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', Auth::user()->phone ?? '') }}" placeholder="08xxxxxxxxxx" required>
                                    @error('shipping_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">                                  
                                <label class="form-label" for="shipping_address">Alamat Lengkap *</label>
                                <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" placeholder="Nama, jalan, nomor rumah, RT/RW, kelurahan, kecamatan" required>{{ old('shipping_address', Auth::user()->address ?? '') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror                                   
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="shipping_city">Kota / Kabupaten *</label>
                                    <input type="text" id="shipping_city" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror" value="{{ old('shipping_city') }}" placeholder="Cth: Purwokerto" required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="shipping_postal_code">Kode pos *</label>
                                    <input type="text" id="shipping_postal_code" name="shipping_postal_code" class="form-control @error('shipping_postal_code') is-invalid @enderror" value="{{ old('shipping_postal_code') }}" placeholder="Cth: 53111" required>
                                    @error('shipping_postal_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">                                  
                                <label class="form-label" for="notes">Catatan
                                    <span style="font-weight: 400; color: var(--text-muted);">(opsional)</span>
                                </label>
                                <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Catatan untuk penjual atau kurir..."></textarea>                                   
                            </div>
                        </div>
                        <div class="checkout-card">
                            <div class="checkout-section-header">
                                <i class="bi bi-credit-card"></i>Metode Pembayaran
                            </div>
                            <div class="payment-method-strip">
                                <div class="icon">💳</div>
                                <div>
                                    <div class="name">Bayar via</div>
                                    <div class="desc">
                                        Transfer Bank, E-wallet (GoPay, OVO, DANA), Kartu Kredit, QRIS
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="checkout-summary-card">
                            <div class="checkout-section-header">
                                <i class="bi bi-receipt"></i>Ringkasan Pesanan
                            </div>
                            @foreach ($cart as $item)
                            <div class="checkout-order-item">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" onerror="this.src='https://via.placeholder.com/60x60/1a1a2e/c9a84c?text=IMG'">
                                <div class="item-info">
                                    <div class="item-name">
                                        {{ $item['name'] }}
                                    </div>
                                    <div class="item-meta">
                                        {{ $item['size'] }} / {{ $item['color'] }} x {{ $item['quantity'] }}
                                    </div>
                                </div>
                                <div class="item-subtotal">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0,',','.') }}
                                </div>
                            </div>
                            @endforeach
                            <div class="mt-3">
                                <div class="checkout-summary-row">
                                    <span class="label">Subtotal</span>
                                    <span class="amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="checkout-summary-row">
                                    <span class="label">Ongkos Kirim</span>
                                    <span class="amount">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="checkout-summary-total">
                                <span>Total Pembayaran</span>
                                <span class="amount">Rp {{ number_format($total, 0,',','.') }}</span>
                            </div>
                            <button type="submit" class="btn-place-order">
                                <i class="bi bi-lock"></i>Buat Pesanan &amp; Bayar
                            </button>
                            <p class="checkout-security-note">
                                <i class="bi bi-shield-check text-success"></i>Pembayaran aman
                            </p>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection