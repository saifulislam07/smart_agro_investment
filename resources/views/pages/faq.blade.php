@extends('layouts.app', ['title' => 'FAQ | GrowUp Agrotech'])

@section('content')
    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">FAQ</span>
            <h1 class="fw-bold mt-2 mb-0">Investor questions, answered.</h1>
        </div>
    </header>
    <main class="section">
        <div class="container">
            <div class="accordion premium-accordion" id="faqPageAccordion">
                @foreach ($faqs as $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqPage{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faqPage{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqPageAccordion">
                            <div class="accordion-body">{{ $faq->answer }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
