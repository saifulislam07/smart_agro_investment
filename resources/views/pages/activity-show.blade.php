@extends('layouts.app', ['title' => $activity['title'] . ' | Smart Agro NGO'])

@section('content')
    <header class="page-hero image-hero detail-hero" style="--hero-image: url('{{ $activity['image'] }}')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">NGO Activity · {{ $activity['date'] }}</span>
                <h1 class="fw-bold mt-2 mb-3">{{ $activity['title'] }}</h1>
                <p class="lead mb-0">{{ $activity['excerpt'] }}</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="row g-5">
                <article class="col-lg-8">
                    <div class="content-box article-detail">
                        <img class="article-main-image" src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}">
                        <p>{{ $activity['content'] }}</p>
                        <p>Through these activities, Smart Agro strengthens farmer readiness, community trust, and market-focused agricultural development.</p>
                    </div>
                </article>
                <aside class="col-lg-4">
                    <div class="sidebar-box">
                        <span class="eyebrow">More Activities</span>
                        @foreach ($related as $item)
                            <a class="related-link" href="{{ route('ngo.activities.show', $item['slug']) }}">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                <span>{{ $item['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
