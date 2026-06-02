@extends('layouts.app', ['title' => 'News | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1495020689067-958852a7765e?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">News</span>
                <h1 class="fw-bold mt-2 mb-3">News</h1>
                <p class="lead mb-0">Latest updates, media coverage, and field stories from Smart Agro.</p>
            </div>
        </div>
    </header>

    <main class="section news-section">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Newsroom</span>
                    <h2 class="fw-bold mt-2">Latest News from Smart Agro</h2>
                </div>
            </div>
            <div class="news-list">
                @foreach ($posts as $post)
                    <article class="news-row animate-soft">
                        <a href="{{ route('news.show', $post) }}">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                            <div>
                                <div class="meta-line">{{ $post->published_at->format('d M Y') }} · Smart Agro</div>
                                <h2 class="h5 fw-bold mt-2">{{ $post->title }}</h2>
                                <p class="text-muted">{{ $post->excerpt }}</p>
                                <span class="read-link">Read News <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </main>
@endsection
