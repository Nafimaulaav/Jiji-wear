@extends('layouts.app')

@section('title', 'Login - JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="auth-card">
                    <div class="row g-0">
                        <div class="col-md-5 auth-left">
                            <h2>Selamat Datang Kembali</h2>
                            <p>Masuk untuk melanjutkan checkout dan melihat pesanan Anda</p>
                            <div class="auth-left-divider">
                                <p class="auth-benefits-title">✨ Keuntungan Member:</p>
                                <ul class="auth-benefits-list">
                                    <li>Check out lebih cepat</li>
                                    <li>Pantau status pesanan</li>
                                    <li>Riwayat belanja lengkap</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7 auth-right">
                            <h3>Masuk</h3>
                            <p class="auth-subtitle">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
                            <form action="{{ route('login') }}" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@gmail.com" required autocomplete="email">@error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror 
                                </div>
                                <div class="mb-3">
                                    <div class="position-relative">
                                        <input type="password" id="passwordInput" name="password" class="form-control @error('password') is-invalid
                                        @enderror" placeholder="Masukkan Password" required autocomplete="current-password"> 
                                        <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordInput', 'eyeIcon')" aria-label="Tampilkan/sembunyikan password">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember" style="font-size: 0.9rem;">Ingat saya</label>
                                    </div>
                                </div>
                                <button type="submit" class="auth-submit-btn">
                                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                                </button>
                            </form>
                            <div class="auth-divider">
                                atau
                            </div>
                            <div class="auth-guest-box">
                                <p>Ingin lihat produk dulu?</p>
                                <a href="{{ route('products.index') }}">Lihat Produk Tanpa Login <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    function togglePassword(inputId, iconId){
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type ='password';
            icon.className = 'bi bi-eye'
        }
    }
</script>
@endpush