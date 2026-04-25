@extends('layouts.app')

@section('title', 'Pembayaran - JijiWear')

@push('head')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
    <div class="payment-section">
        <div class="container">
            <div class="step-indicator">
                <div class="step">
                    <div class="step-num done">
                        <i class="bi bi-check"></i>
                    </div>
                    <span class="step-label">Keranjang</span>
                </div>
                <div class="step-line done"></div>
                <div class="step">
                    <div class="step-num done">
                        <i class="bi bi-check"></i>
                    </div>
                    <span class="step-label">Pengiriman</span>
                </div>
                <div class="step-line done"></div>
                <div class="step">
                    <div class="step-num active-step">3</div>
                    <span class="step-label active">Pembayaran</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-num waiting">4</div>
                    <span class="step-label">Selesai</span>
                </div>  
            </div>
            <div class="payment-card">
                <span class="payment-card-icon">💳</span>
                <h2>Selesaikan Pembayaran</h2>
                <p class="payment-order-number">
                    Nomor Pesanan: <strong>{{ $order -> order_number }}</strong>
                </p>
                <div class="payment-amount">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </div>
                <div class="payment-items-summary">
                    @foreach ($order->items as $item)
                    <div class="item-row">
                        <span>{{ $item->product->name ?? 'Produk tidak tersedia'}} ({{ $item->size }}/{{ $item->color }}) × {{ $item->quantity }}</span>
                        <strong>Rp {{ number_format($item->subtotal, 0,',','.') }}</strong>
                    </div>
                    @endforeach
                    <div class="item-row shipping-row">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button id="pay-button" class="btn-pay-now" onclick="payNow()">
                    <i class="bi bi-shield-lock"></i>
                    Bayar Sekarang
                </button>
                <p class="payment-info-note">
                    Klik "Bayar Sekarang" untuk menyelesaikan pembayaran. Anda akan diarahkan ke halaman pembayaran. <br>
                    Tersedia berbagai metode pembayaran: Transfer Bank, E-wallet (GoPay, OVO, DANA), Kartu Kredit, QRIS.
                </p>

                <div class="payment-security-note">
                    <i class="bi bi-shield-check text-success"></i>
                    <span>Transaksi ini aman dan terenkripsi.</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const snapToken  = "{{ $snapToken }}";
    const hasSession = "{{ session('snap_token') ? 'yes' : 'no' }}";
    const successUrl = "{{ route('checkout.success') }}";
    const ordersUrl  = "{{ route('orders.index') }}";

    function payNow() {
        window.snap.pay(snapToken, {
            onSuccess: function (result) {
                console.log('Payment success', result);
                window.location.href = successUrl;
            },
            onPending: function (result) {
                console.log('Payment pending', result);
                alert('Pembayaran sedang diproses. Silakan selesaikan pembayaran.');
                window.location.href = ordersUrl;
            },
            onError: function (result) {
                console.error('Payment error', result);
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function () {
                console.log('Popup ditutup tanpa menyelesaikan pembayaran.');
            }
        });
    }

    if (hasSession === 'yes') {
        window.addEventListener('load', function () {
            setTimeout(payNow, 800);
        });
    }
</script>
@endpush