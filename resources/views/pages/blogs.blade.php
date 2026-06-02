@extends('layouts.app', ['title' => 'Blog | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Blog</span>
                <h1 class="fw-bold mt-2 mb-3">Blog</h1>
                <p class="lead mb-0">Thoughts on agrotech, ethical investment, food security, and rural empowerment.</p>
            </div>
        </div>
    </header>

    <main class="section journal-section">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Insights</span>
                    <h2 class="fw-bold mt-2">Latest Blog from Smart Agro</h2>
                </div>
            </div>
            <div class="journal-grid">
                @foreach ($posts as $post)
                    <article class="journal-card animate-soft {{ $loop->first ? 'featured' : '' }}">
                        <a href="{{ route('blogs.show', $post) }}">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                            <div class="journal-body">
                                <div class="meta-line">{{ $post->published_at->format('d M Y') }} · Smart Agro</div>
                                <h2 class="h5 fw-bold mt-2">{{ $post->title }}</h2>
                                <p class="text-muted">{{ $post->excerpt }}</p>
                                <span class="read-link">Read Article <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </main>
@endsection
