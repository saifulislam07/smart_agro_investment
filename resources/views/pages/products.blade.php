@extends('layouts.app', ['title' => 'Products | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Products</span>
                <h1 class="fw-bold mt-2 mb-3">Products</h1>
                <p class="lead mb-0">Fresh, verified, and value-added products from the Smart Agro supply chain.</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="category-cloud mb-4">
                <a class="{{ request('category') ? '' : 'active' }}" href="{{ route('products.index') }}">All</a>
                @foreach ($categories as $category)
                    <a class="{{ request('category') === $category ? 'active' : '' }}" href="{{ route('products.index', ['category' => $category]) }}">{{ $category }}</a>
                @endforeach
            </div>
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-xl-3">
                        <article class="product-card animate-soft">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                            <div class="p-3">
                                <span class="badge rounded-pill">{{ $product->badge }}</span>
                                <h2 class="h6 fw-bold mt-3 mb-1">{{ $product->name }}</h2>
                                <span class="text-muted small">{{ $product->category }}</span>
                                <div class="fw-bold mt-2">BDT {{ number_format($product->price) }}</div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
