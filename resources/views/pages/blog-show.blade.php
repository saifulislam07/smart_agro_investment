@extends('layouts.app', ['title' => $post->title . ' | Smart Agro Blog'])

@section('content')
    <header class="page-hero image-hero detail-hero" style="--hero-image: url('{{ $post->image }}')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Blog · {{ $post->published_at->format('d M Y') }}</span>
                <h1 class="fw-bold mt-2 mb-3">{{ $post->title }}</h1>
                <p class="lead mb-0">{{ $post->excerpt }}</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="row g-5">
                <article class="col-lg-8">
                    <div class="content-box article-detail">
                        <img class="article-main-image" src="{{ $post->image }}" alt="{{ $post->title }}">
                        <p>{{ $post->content }}</p>
                        <p>Smart Agro continues to publish practical insight for people who care about responsible agriculture, transparent reporting, and well-managed investment cycles.</p>
                    </div>
                </article>
                <aside class="col-lg-4">
                    <div class="sidebar-box">
                        <span class="eyebrow">Related Blogs</span>
                        @foreach ($related as $item)
                            <a class="related-link" href="{{ route('blogs.show', $item) }}">
                                <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                <span>{{ $item->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
