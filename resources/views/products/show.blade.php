@extends('layouts.app')

@section('title', $product->name . '- JijiWear')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')

<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Produk</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="product-main">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image-main" onerror="this.src='https://via.placeholder.com/500x500/1a1a2e/c9a84c?text={{ urlencode($product->name) }}'">
                <div class="mt-3 text-center">
                    @if ($product->stock > 10)
                        <span class="badge stock-indicator bg-success"> ✅ Tersedia &nbsp; &nbsp; Stok: {{ $product->stock }} </span>
                    @elseif($product->stock > 0)
                        <span class="bagde stock-indicator bg-warning text-dark"> ⚠️ Stok Terbatas: {{ $product->stock }}</span>
                    @else
                        <span class="bagde stock-indicator bg-secondary">❌ Stok Habis</span>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="product-detail-category">{{ $product->category->name }}</div>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-price-main">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <p class="product-description">{{ $product->description }}</p>
                @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" id="addToCartForm">
                    @csrf
                    @if ($product->sizes)
                    <div class="mt-4">
                        <div class="selector-label">
                            Ukuran
                            <span class="selector-selected-value" id="selectedSizeLabel"></span>
                        </div>
                        <div class="size-selector-group">
                            @foreach ($product->sizes as $size)
                                <button type="button" class="size-btn" onclick="selectSize('{{ $size }}',this)">{{ $size }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" name="size" id="sizeInput">
                    </div>
                    @endif
                    @if ($product->colors)
                    <div class="mt-3">
                        <div selector-label>
                            Warna
                            <span class="selector-selected-value" id="selectedColorLabel"></span>
                        </div>
                        <div class="color-selection-group">
                            @foreach ($product->colors as $color)
                                <button type="button" class="color-btn" onclick="selectColor('{{ $color }}', this)">{{ $color }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" name="color" id="colorInput">
                    </div>
                    @endif
                    <div class="mt-3">
                        <div class="selector-label">Jumlah</div>
                        <div class="qty-control"><button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                        <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                        <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                        <span class="qty-max-hint">Maks. {{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn-add-cart">
                            <i class="bi bi-bag-plus"></i>Tambah ke Keranjang
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn-bag-icon">
                            <i class="bi bi-bag f-5"></i>
                        </a>
                    </div>
                </form>
                @else
                <div class="alert alert-secondary mt-4">
                    <i class="bi bi-info-circle me-2"></i> Produk ini sekarang tidak tersedia
                </div>
                @endif
                <div class="product-info-box">
                    <div class="product-info-item">
                        <i class="bi bi-truck"></i>
                        <span>Pengiriman ke seluruh Indonesia. Estimasi 2 - 7 hari</span>
                    </div>
                    <div class="product-info-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Pembayran aman 100%</span>
                    </div>
                    <div class="product-info-item">
                        <i class="bi bi-arrow-return-left"></i>
                        <span>Retur mudah dalam 7 hari jika ada kerusakan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($related->count() > 0)
<div class="related-saction">
    <div class="container">
        <h2 class="related-title">Produk Serupa</h2>
        <div class="row g-4">
            @foreach ($related as $rel)
            <div class="col-sm-6 col-lg-3">
                <div class="related-card card">
                    <img src="{{ $rel->image }}" class="card-img-top" alt="{{ $rel->name }}" onerror="this.src='https://via.placeholder.com/300x200/1a1a2e/c9a84c?text={{ urlencode($rel->name) }}'">
                    <div class="card-body">
                        <div class="card-price">Rp {{ number_format($rel->price, 0,',','.') }}</div>
                        <a href="{{ route('products.show', $rel->slug) }}" class="btn-related-view mt-2">Lihat Produk</a>
                    </div>
                </div>
            </div>   
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    function selectSize(size, el){
        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selected'));
        el.classlist.add('selected');
        document.getElementById('sizeInput').value = size;
        document.getElementById('selectedSizeLabel').textContent = '- ' + size;
    }

    function selectColor(color, el){
        document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('colorInput').value = color;
        document.getElementById('selectedColorLabel').textContent = '-' + color;
    }

    function changeQty(delta) {
        const input = document.getElementById('qtyInput');
        const val = parseInt(input.value) + delta;
        const max = parseInt(input.max);
        if (val >= 1 && val <= max) input.value = val;
    }

    document.getElementById('addToCartForm')?.addEventListener('submit', function(e){
        const size = document.getElementById('sizeInput').value;
        if (!size) {e.preventDefault(); alert('Pilih ukuran terlebih dahulu!'); return;}
        if (!color) {e.defaultPrevented(); alert('Pilih warna terlebih dahulu!'); return;}
    });
</script>



