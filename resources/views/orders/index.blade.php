@extends('layouts.app')

@section('title', 'Pesanan saya - JijiWear')

@push ('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('content')
    <div class="orders-section">
        <div class="container">
            <div class="orders-page-header">
                <h1 class="orders-page-title">
                    <i class="bi bi-box"></i>Pesanan Saya
                </h1>
                <a href="{{ route('products.index') }}" class="btn-shop-again">
                    <i class="bi bi-plus-lg"></i>Belanja Lagi
                </a>
            </div>
            @if ($orders->count() > 0)
                @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-card-number">
                        <span class="order-card-number">{{ $order->order_number }}</span>
                        <div class="order-card-header-right">
                            <span class="order-card-date">{{ $order->created_at -> format('d M Y')}}</span>
                            <span class="status-badge-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    <div class="order-card-body">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <div class="order-item-preview">
                                    @foreach ($order->items->take(2) as $item)
                                        <div>
                                            {{ $item->product->name ?? 'Produk dihapus' }}
                                            {{ $item->size }}/{{ $item->color }} × {{ $item->quantity }}
                                        </div>
                                    @endforeach
                                    @if ($order->items->count() > 2)
                                        <div class="more-item">
                                            +{{ $order->items->count() - 2 }} item lainnya
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mt-md-0 text-md-center">
                                <div class="order-total-label">Total</div>
                                <div class="order-total-amount">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-md-2 mt-2 mt-md-0 text-md-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn-order-detail">
                                    <i class="bi bi-eye"></i>Detail
                                </a>
                                @if ($order->status === 'pending' && $order->payment)
                                    <a href="{{ route('checkout.payment', $order->id) }}">
                                        <i class="bi bi-credit-card"></i> Bayar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-orders">
                    <span class="icon">📦</span>
                    <h4>Belum Ada Pesanan</h4>
                    <p>Ayo mulai belanja dan temukan produk favoritmu!</p>
                    <a href="{{ route('products.index') }}" class="btn-ordes-shop">
                        <i class="bi bi-bag"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection