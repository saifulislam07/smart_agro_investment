@extends('layouts.app', ['title' => 'Smart Agro Projects | Smart Agro'])

@section('content')
    <header class="page-hero image-hero" style="--hero-image: url('https://images.unsplash.com/photo-1523741543316-beb7fc7023d8?auto=format&fit=crop&w=1800&q=80')">
        <div class="container">
            <div class="hero-copy animate-soft">
                <span class="eyebrow">Investment Projects</span>
                <h1 class="fw-bold mt-2 mb-3">Browse Smart Agro projects.</h1>
                <p class="lead mb-0">Filter by category, status, and business type, then compare ROI, duration, maturity, and funding progress.</p>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <form class="filter-bar mb-4" method="GET" action="{{ route('projects.index') }}">
                <div>
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Business Type</label>
                    <select class="form-select" name="business_type">
                        <option value="">All types</option>
                        @foreach ($businessTypes as $type)
                            <option value="{{ $type }}" @selected(request('business_type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Sort By</label>
                    <select class="form-select" name="sort">
                        <option value="">Latest</option>
                        <option value="roi" @selected(request('sort') === 'roi')>ROI</option>
                        <option value="goal" @selected(request('sort') === 'goal')>Investment goal</option>
                        <option value="start_date" @selected(request('sort') === 'start_date')>Start date</option>
                    </select>
                </div>
                <div class="d-flex gap-2 align-items-end">
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel me-2"></i>Filter</button>
                    <a class="btn btn-outline-dark" href="{{ route('projects.index') }}"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>

            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="sidebar-box">
                        <span class="eyebrow">Quick Summary</span>
                        <div class="mini-stat mt-3"><strong>{{ $quickStats['total'] }}</strong><span>Total projects</span></div>
                        <div class="mini-stat"><strong>{{ $quickStats['live'] }}</strong><span>Live projects</span></div>
                        <div class="mini-stat"><strong>BDT {{ number_format($quickStats['raised']) }}</strong><span>Total raised</span></div>
                        <div class="mini-stat"><strong>BDT {{ number_format($quickStats['goal']) }}</strong><span>Total goal</span></div>
                        <div class="tip-box mt-3">
                            <strong>Investment tip</strong>
                            <p class="mb-0">Compare maturity date, project duration, and minimum investment before submitting an amount.</p>
                        </div>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="row g-4">
                        @forelse ($projects as $project)
                            @php
                                $progress = min(100, ((float) $project->raised / (float) $project->goal) * 100);
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <article class="project-card">
                                    <div class="project-image">
                                        <img src="{{ $project->image }}" alt="{{ $project->title }}">
                                        <span class="status {{ $project->is_live ? 'live' : 'closed' }}">{{ $project->is_live ? 'LIVE' : 'CLOSED' }}</span>
                                    </div>
                                    <div class="p-4">
                                        <span class="eyebrow">{{ $project->category }}</span>
                                        <h2 class="h5 fw-bold mt-2">{{ $project->title }}</h2>
                                        <p class="text-muted small">{{ $project->summary }}</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between small mb-3">
                                            <span>Raised: BDT {{ number_format($project->raised) }}</span>
                                            <strong>{{ round($progress) }}%</strong>
                                        </div>
                                        <div class="data-grid">
                                            <span>ROI<strong>{{ $project->roi }}</strong></span>
                                            <span>Min Invest<strong>BDT {{ number_format($project->minimum_investment) }}</strong></span>
                                            <span>Duration<strong>{{ $project->duration }}</strong></span>
                                            <span>Status<strong>{{ $project->status }}</strong></span>
                                        </div>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-primary w-100 mt-4">View Details</a>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">No projects matched your filters.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-4">{{ $projects->links() }}</div>
                </div>
            </div>
        </div>
    </main>
@endsection
