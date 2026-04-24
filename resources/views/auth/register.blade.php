@extends('layouts.app')

@section('title', 'Daftar - JijiWear')

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
                        <div class="col-md-5 auth-left d-none d-md-flex">
                            <div>
                                <span class="auth-left-icon">✨</span>
                                <h2>Bergabung Bersama Kami!</h2>
                                <p>Daftar sekarang dan nikmati pengalaman belanja kualitas terbaik.</p>
                                <div class="auth-left-divider">
                                    <p class="auth-benefits-title">🎁 Gratis mendaftar:</p>
                                    <ul class="auth-benefits-list">
                                        <li>Akses semua produk</li>
                                        <li>Notifikasi promo eksklusif</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 auth-right">
                            <h3>Buat Akun Baru</h3>
                            <p class="auth-subtitle">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                            <form action="{{ route('register') }}" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="name">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name')is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" required autocomplete="name"> @error('name') <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Alamat Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@gmail.com" required autocomplete="email"> @error('email') <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Nomor Hp <span style="font-weight: 400; color: var(--text-muted);">(opsional)</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xxxxxxxxx" autocomplete="tel">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="position-relative">
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid
                                            @enderror" placeholder="Min. 8 karakter" required autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" onclick="togglePassword('password', 'eyeIcon1')" aria-label="Tampilkan Password">
                                                <i class="bi bi-eye" id="eyeIcon1"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}
        
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="password_confirmation">Konfirmasi</label>                                        
                                        <div class="position-relative">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', 'eyeIcon2')" aria-label="tampilkan konfirmasi password"><i class="bi bi-eye" id="eyeIcon2"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check auth-terms">
                                        <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                                        @error('agree')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <label class="form-check-label" for="agree">Saya setuju dengan <a href="#">Syarat &amp; Ketentuan</a> yang berlaku</label>
                                    </div>
                                </div>
                                <button type="submit" class="auth-submit-btn">
                                    <i class="bi bi-person-plus"></i> Buat Akun
                                </button>
                            </form>
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
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password'){
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

@endpush