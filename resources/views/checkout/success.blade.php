@extends('layouts.app')

@section('title', 'Pesanan Berhasil - JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
    <div class="success-section">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h2>Pesanan Berhasil</h2>
                <p>
                    Terimakasih atas pesananmu! Kami akan segera memproses dan mengirimkan pesananmu. Kamu bisa memantau status pesanan di halaman <strong>Pesanan Saya</strong>
                </p>
                <div class="success-email-box">
                    <span class="icon">📧</span>
                    <div class="info">
                        Konfirmasi pesanan telah dikirim ke email: <strong>{{ Auth::user()->email ?? '' }}</strong>
                    </div>
                </div>
                <div class="success-actions">
                    <a href="{{ route('orders.index') }}" class="btn-success-orders">
                        <i class="bi bi-box"></i>Lihat Pesanan
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-success-shop">
                        <i class="bi bi-bag"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection