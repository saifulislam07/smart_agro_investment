@extends('layouts.app', ['title' => 'Properties | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Properties</span>
                <h1 class="fw-bold mt-2 mb-3">Property</h1>
                <p class="lead mb-0">Explore commercial, residential, health, eco-tourism, and agro-backed property opportunities.</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">All Properties</span>
                    <h2 class="fw-bold mt-2">Smart Agro Property Portfolio</h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($properties as $property)
                    <div class="col-md-6 col-xl-4">
                        <article class="simple-card animate-soft">
                            <img src="{{ $property->image }}" alt="{{ $property->title }}">
                            <div class="p-4">
                                <span class="eyebrow">{{ $property->type }}</span>
                                <h3 class="h5 fw-bold mt-2">{{ $property->title }}</h3>
                                <p class="text-muted">{{ $property->summary }}</p>
                                <div class="d-flex justify-content-between small fw-semibold">
                                    <span><i class="bi bi-geo-alt me-1"></i>{{ $property->location }}</span>
                                    <span>{{ $property->roi }}</span>
                                </div>
                                <div class="price mt-3">{{ $property->price_range }}</div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
