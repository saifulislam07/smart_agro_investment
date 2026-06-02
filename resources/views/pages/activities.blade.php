@extends('layouts.app', ['title' => 'NGO Activities | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">See Outstanding Projects We Have Implemented</span>
                <h1 class="fw-bold mt-2 mb-3">Smart Agro NGO Activities</h1>
                <p class="lead mb-0">Community-focused initiatives inspired by ROSA's rural development legacy.</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Our Initiatives</span>
                    <h2 class="fw-bold mt-2">Smart Agro NGO Activities</h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($activities as $activity)
                    <div class="col-md-6 col-xl-4">
                        <article class="simple-card article-card animate-soft">
                            <a href="{{ route('ngo.activities.show', $activity['slug']) }}">
                                <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}">
                            </a>
                            <div class="p-4">
                                <div class="meta-line">{{ $activity['date'] }} · Smart Agro</div>
                                <h2 class="h5 fw-bold mt-2">{{ $activity['title'] }}</h2>
                                <p class="text-muted">{{ $activity['excerpt'] }}</p>
                                <a class="read-link" href="{{ route('ngo.activities.show', $activity['slug']) }}">View Activity <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
