@extends('layouts.app')

@section('title', 'Detail Pesanan - JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endpush

@section('content')
<div class="order-detail-section">
    <div class="container">

        <div class="order-detail-header">
            <a href="{{ route('orders.index') }}" class="btn-back-orders">
                <i class="bi bi-arrow-left"></i>Kembali
            </a>
            <h1 class="order-detail-title">Detail Pesanan</h1>
        </div>

        <div class="row g-4">

            {{-- Kolom kiri --}}
            <div class="col-lg-8">

                {{-- Informasi pesanan --}}
                <div class="detail-card">
                    <div class="detail-order-meta">
                        <div>
                            <div class="detail-order-number-label">
                                Nomor Pesanan
                            </div>
                            <div class="detail-order-number-value">
                                {{ $order->order_number }}
                            </div>
                            <div class="detail-order-date">
                                Dipesan: {{ $order->created_at->format('d M Y, H:i') }} WIB
                            </div>
                        </div>

                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                {{-- Item pesanan --}}
                <div class="detail-card">
                    <div class="detail-section-title">
                        <i class="bi bi-bag"></i>Item Pesanan
                    </div>

                    @foreach ($order->items as $item)
                    <div class="detail-item-row">
                        <img src="{{ $item->product->image_url ?? '#' }}"
                             alt="{{ $item->product->name ?? '' }}"
                             class="detail-item-img"
                             onerror="this.src='https://via.placeholder.com/65x65/1a1a2e/c9a84c?text=IMG'">

                        <div class="detail-item-info">
                            <div class="detail-item-name">
                                {{ $item->product->name ?? 'Produk tidak tersedia' }}
                            </div>
                            <div class="detail-item-attrs">
                                Ukuran: {{ $item->size }} &nbsp;·&nbsp;
                                Warna: {{ $item->color }} &nbsp;·&nbsp;
                                Qty: {{ $item->quantity }}
                            </div>
                            <div class="detail-item-unit-price">
                                Harga: Rp {{ number_format($item->price, 0, ',', '.') }} / pcs
                            </div>
                        </div>

                        <div class="detail-item-subtotal">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Alamat pengiriman --}}
                <div class="detail-card">
                    <div class="detail-section-title">
                        <i class="bi bi-geo-alt"></i>Alamat Pengiriman
                    </div>

                    <div class="detail-shipping-address">
                        <strong>{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                    </div>

                    @if ($order->notes)
                        <div class="detail-shipping-notes">
                            <strong>Catatan:</strong><br>
                            {{ $order->notes }}
                        </div>
                    @endif
                </div>

            </div>

            {{-- Kolom kanan --}}
            <div class="col-lg-4">

                {{-- Ringkasan pembayaran --}}
                <div class="detail-card">
                    <div class="detail-section-title">
                        <i class="bi bi-receipt"></i>Ringkasan Pembayaran
                    </div>

                    <div class="detail-summary-row">
                        <span class="label">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="detail-summary-row">
                        <span class="label">Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    <div class="detail-total-row">
                        <span>Total</span>
                        <span class="amount">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Info pembayaran --}}
                @if($order->payment)
                <div class="detail-card">
                    <div class="detail-section-title">
                        <i class="bi bi-credit-card"></i>Info Pembayaran
                    </div>

                    <div class="payment-info-list">
                        <div>
                            <span class="label">Status: </span>
                            @if($order->payment->status === 'success')
                                <span class="payment-status-success">Lunas ✓</span>
                            @elseif($order->payment->status === 'failed')
                                <span class="payment-status-failed">Gagal ✗</span>
                            @else
                                <span class="payment-status-pending">Menunggu Pembayaran</span>
                            @endif
                        </div>

                        @if($order->payment->payment_type)
                        <div>
                            <span class="label">Metode: </span>
                            {{ ucfirst(str_replace('_', ' ', $order->payment->payment_type)) }}
                        </div>
                        @endif

                        @if($order->payment->transaction_id)
                        <div>
                            <span class="label">ID Transaksi: </span>
                            <span style="font-size: 0.85rem;">
                                {{ $order->payment->transaction_id }}
                            </span>
                        </div>
                        @endif
                    </div>

                    @if($order->status === 'pending' && $order->payment->status === 'pending')
                        <a href="{{ route('checkout.payment', $order->id) }}"
                           class="btn-complete-payment">
                            <i class="bi bi-credit-card"></i>
                            Selesaikan Pembayaran
                        </a>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection