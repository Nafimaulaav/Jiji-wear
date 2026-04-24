@extends ('layouts.app')

@section('title', 'Produk - JijiWear')

@push ('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')

<div class="hero-banner">
    <div class="container">
        <h1>Koleksi <span class="highlight">Fashion</span> Kami</h1>
        <p>Temukan baju impianmu dari ratusan koleksi terbaik!</p>
    </div>
</div>

<div class="container">
    <div class="filter-bar">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="filter-label">Kategori</span>
                <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), [])) }}" class="category-pill {{ !request('category') ? 'active' : '' }}">Semua</a>
                @foreach ($categories as $cat )
                    <a href="{{ route('products.index', array_merge(request()->except('category', 'page'),['category' => $cat->slug])) }}" class="category-pill {{ request('category') == $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <form action="{{ route('products.index') }}" method="GET">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="">Urutkan: Terbaru</option>
                        <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>
                            Harga: Terendah
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Harga: Tertinggi
                        </option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <p class="results-info">
        Menampilkan <strong>{{ $products->count() }}</strong> dari <strong>{{ $products->total() }}</strong>
        @if (request('search'))
            untuk <strong>{{ request('search') }}</strong>
        @endif
    </p>

    @if ($products->count() > 0)
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-sm-6 col-lg-4">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" loading="lazy" onerror="this.src='https://via.placeholder.com/400x280/1a1a2e/c9a84c?text={{ urlencode($product->name) }}'">
                            @if ($product->stock <= 5 && $product->stock > 0)
                                <span class="product-stock-badge limited">Stok Terbatas!</span> 
                            @elseif ($product->stock == 0)
                                <span class="product-stock-badge out-of-stock">Habis</span>
                            @endif

                            <div class="product-overlay">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-light w-100" style="border-radius: 8px; font-weight: 600;">
                                    <i class="bi bi-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                        <div class="product-body">
                            <div class="product-category-label">{{ $product->category->name }}</div>
                            <div class="product-name">{{ $product->name }}</div>

                            @if ($product->sizes)
                                <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                                    @foreach (array_slice($product->sizes, 0, 3) as $size)
                                        <span class="size-chip">{{ $size }}</span>                                    
                                    @endforeach
                                    @if (count($product->sizes) > 3)
                                        <span style="font-size: 0.72rem; color: var(--text-muted);">
                                            +{{ count($product->sizes) - 3 }}
                                        </span>           
                                    @endif
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="product-price">
                                    Rp {{ number_format($product->price, 0,',','.') }}
                                </div>
                                <div class="product-stock-info">
                                    Stok: {{ $product->stock }}
                                </div>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn-view-product">Lihat Produk</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5 mb-3">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @else
    <div class="no-products">
        <span class="icon">🔍</span>
        <h4>Produk Tidak Ditemukan</h4>
        <p>Coba ubah filter atau kata kunci pencarian.</p>
        <a href="{{ route('products.index') }}" class="btn-primary-custom mt-3">Lihat Semua Produk</a>
    </div>    
    @endif
</div>

@endsection
