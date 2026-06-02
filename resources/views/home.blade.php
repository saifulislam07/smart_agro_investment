@extends('layouts.app', ['title' => 'Smart Agro'])

@section('content')

    <header id="homeHero" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="5200">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#homeHero" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#homeHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#homeHero" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            @foreach ([
                ['image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=2400&q=88', 'alt' => 'Wide agricultural field at sunrise'],
                ['image' => 'https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?auto=format&fit=crop&w=2400&q=88', 'alt' => 'Farmers working in a green agriculture field'],
                ['image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2400&q=88', 'alt' => 'Young crop seedlings growing in soil'],
            ] as $slide)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="hero-image-slide">
                        <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] }}">
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeHero" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeHero" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </header>

    <main>
        <section class="section-sm">
            <div class="container">
                <div class="stats-grid">
                    @foreach ($stats as $stat)
                        <div class="stat-item">
                            <strong>{{ $stat['value'] }}</strong>
                            <span>{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section" id="about">
            <div class="container">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-5">
                        <div class="cert-box h-100">
                            <div class="eyebrow mb-2">Certification at a Glance</div>
                            <h2 class="h3 fw-bold mb-4">Smart Agro</h2>
                            <ul class="check-list">
                                @foreach ($certifications as $item)
                                    <li><i class="bi bi-check-circle-fill"></i>{{ $item }}</li>
                                @endforeach
                            </ul>
                            <div class="rosa mt-4">
                                <strong>Rural Organisations for Social Affairs (ROSA)</strong>
                                <span>Established in 1992, registered with DSS, MRA and NGO Affairs Bureau.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-copy h-100">
                            <span class="eyebrow">Who We Are?</span>
                            <h2 class="fw-bold mt-2 mb-3">A farmer-first ecosystem for capital, knowledge, produce, and markets.</h2>
                            <p>For decades, ROSA NGO has worked with farmers across Bangladesh and observed how short repayment cycles, limited financial planning, and inconsistent market access keep many farmers under pressure.</p>
                            <p>Smart Agro turns that experience into a structured agro platform: investors fund managed projects, farmers receive operational support, and buyers access verified products through a more organized supply chain.</p>
                            <div class="category-cloud mt-4">
                                @foreach ($categories as $category)
                                    <span>{{ $category }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section muted" id="projects">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Smart Agro Projects</span>
                        <h2 class="fw-bold mt-2">Featured Investment Projects</h2>
                    </div>
                    <div class="project-tabs">
                        <button class="active" type="button" data-project-filter="all">All Projects {{ $projects->count() }}</button>
                        <button type="button" data-project-filter="live">Live {{ $projects->where('is_live', true)->count() }}</button>
                        <button type="button" data-project-filter="mature">Mature {{ $projects->where('is_live', false)->count() }}</button>
                    </div>
                </div>
                <div class="row g-4" id="featuredProjectsGrid">
                    @foreach ($projects as $project)
                        @php
                            $waiting = max((float) $project->goal - (float) $project->raised, 0);
                            $progress = min(100, ((float) $project->raised / (float) $project->goal) * 100);
                        @endphp
                        <div class="col-md-6 col-xl-4" data-project-status="{{ $project->is_live ? 'live' : 'mature' }}">
                            <article class="project-card">
                                <div class="project-image">
                                    <img src="{{ $project->image }}" alt="{{ $project->title }}">
                                    <span class="status {{ $project->is_live ? 'live' : 'closed' }}">{{ $project->is_live ? 'LIVE' : 'CLOSED' }}</span>
                                </div>
                                <div class="p-4">
                                    <div class="d-flex justify-content-between gap-3 mb-2">
                                        <h3 class="h5 fw-bold mb-0">{{ $project->title }}</h3>
                                        <span class="roi">{{ $project->roi }}</span>
                                    </div>
                                    <p class="text-muted small mb-3">{{ $project->summary }}</p>
                                    <div class="progress mb-3" role="progressbar" aria-label="Investment progress" aria-valuenow="{{ round($progress) }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="data-grid">
                                        <span>Business type<strong>{{ $project->business_type }}</strong></span>
                                        <span>Duration<strong>{{ $project->duration }}</strong></span>
                                        <span>Start Date<strong>{{ $project->start_date->format('d-m-Y') }}</strong></span>
                                        <span>Mature Date<strong>{{ $project->mature_date->format('d-m-Y') }}</strong></span>
                                        <span>Investment goal<strong>BDT {{ number_format($project->goal, 2) }}</strong></span>
                                        <span>Min. Investment<strong>BDT {{ number_format($project->minimum_investment, 2) }}</strong></span>
                                        <span>Raised<strong>BDT {{ number_format($project->raised, 2) }}</strong></span>
                                        <span>In waiting<strong>BDT {{ number_format($waiting, 2) }}</strong></span>
                                    </div>
                                    <div class="d-flex gap-2 mt-4">
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-dark w-50">Details</a>
                                        @if ($project->is_live)
                                            <a href="{{ route('projects.show', $project) }}" class="btn btn-primary w-50">Invest Now</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section" id="properties">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Properties</span>
                        <h2 class="fw-bold mt-2">Agro-Backed Property Opportunities</h2>
                    </div>
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-dark">See All Properties</a>
                </div>
                <div class="row g-4">
                    @foreach ($properties as $property)
                        <div class="col-md-4">
                            <article class="simple-card">
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
        </section>

        <section class="section muted" id="products">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Explore by Category</span>
                        <h2 class="fw-bold mt-2">Browse Our Featured Products</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark">See All Products</a>
                </div>
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-6 col-lg-4 col-xl-2">
                            <article class="product-card">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                <div class="p-3">
                                    <span class="badge rounded-pill">{{ $product->badge }}</span>
                                    <h3 class="h6 fw-bold mt-3 mb-1">{{ $product->name }}</h3>
                                    <span class="text-muted small">{{ $product->category }}</span>
                                    <div class="fw-bold mt-2">BDT {{ number_format($product->price) }}</div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section" id="faq">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-5">
                        <span class="eyebrow">Question & Answer</span>
                        <h2 class="fw-bold mt-2 mb-3">Frequently Asked Questions</h2>
                        <p class="text-muted">Find quick answers to common investor questions about projects, profit sharing, maturity, and reporting.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">Contact with Us</a>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion premium-accordion" id="faqAccordion">
                            @foreach ($faqs as $faq)
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                    <div id="faq{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">{{ $faq->answer }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section muted">
            <div class="container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Smart Agro Recent Activities</span>
                        <h2 class="fw-bold mt-2">News, Blog & Field Updates</h2>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($posts as $post)
                        <div class="col-md-4">
                            <article class="simple-card">
                                @php
                                    $postUrl = $post->type === 'Blog' ? route('blogs.show', $post) : route('news.show', $post);
                                @endphp
                                <a href="{{ $postUrl }}">
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}">
                                </a>
                                <div class="p-4">
                                    <div class="d-flex justify-content-between small text-muted mb-3">
                                        <span>{{ $post->type }}</span>
                                        <span>{{ $post->published_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="h5 fw-bold"><a class="text-reset" href="{{ $postUrl }}">{{ $post->title }}</a></h3>
                                    <p class="text-muted mb-0">{{ $post->excerpt }}</p>
                                    <a class="read-link d-inline-block mt-3" href="{{ $postUrl }}">Read More <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="eyebrow">Testimonials</span>
                    <h2 class="fw-bold mt-2">National & Global Confidence</h2>
                </div>
                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <article class="testimonial">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->name }}">
                                    <div>
                                        <strong>{{ $testimonial->name }}</strong>
                                        <span>{{ $testimonial->designation }}</span>
                                    </div>
                                </div>
                                <p>{{ $testimonial->quote }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
