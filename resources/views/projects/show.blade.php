@extends('layouts.app', ['title' => $project->title . ' | Smart Agro'])

@section('content')
    @php
        $progress = min(100, ((float) $project->raised / (float) $project->goal) * 100);
        $waiting = max((float) $project->goal - (float) $project->raised, 0);
    @endphp

    <header class="project-detail-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <span class="eyebrow">{{ $project->category }} · {{ $project->status }}</span>
                    <h1 class="fw-bold mt-2 mb-3">{{ $project->title }}</h1>
                    <p class="lead">{{ $project->summary }}</p>
                    <div class="progress my-4">
                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="hero-metrics">
                        <span>Raised<strong>BDT {{ number_format($project->raised, 2) }}</strong></span>
                        <span>Goal<strong>BDT {{ number_format($project->goal, 2) }}</strong></span>
                        <span>ROI<strong>{{ $project->roi }}</strong></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img class="detail-image" src="{{ $project->image }}" alt="{{ $project->title }}">
                </div>
            </div>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-box mb-4">
                        <h2 class="h4 fw-bold">Project Narrative</h2>
                        <p>{{ $project->description }}</p>
                        <h3 class="h5 fw-bold mt-4">Market Opportunity</h3>
                        <p>{{ $project->market_opportunity }}</p>
                        <h3 class="h5 fw-bold mt-4">Risk Factors</h3>
                        <p>{{ $project->risk_factors }}</p>
                    </div>

                    <div class="content-box">
                        <h2 class="h4 fw-bold mb-3">Project Gallery</h2>
                        <div class="row g-3">
                            @foreach (($project->gallery ?? []) as $image)
                                <div class="col-sm-4">
                                    <img class="gallery-img" src="{{ $image }}" alt="{{ $project->title }} gallery image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <aside class="col-lg-4">
                    <div class="invest-box">
                        <h2 class="h4 fw-bold">Invest Now</h2>
                        <div class="data-grid my-3">
                            <span>Business type<strong>{{ $project->business_type }}</strong></span>
                            <span>Duration<strong>{{ $project->duration }}</strong></span>
                            <span>Start Date<strong>{{ $project->start_date->format('d-m-Y') }}</strong></span>
                            <span>Mature Date<strong>{{ $project->mature_date->format('d-m-Y') }}</strong></span>
                            <span>Minimum<strong>BDT {{ number_format($project->minimum_investment, 2) }}</strong></span>
                            <span>Waiting<strong>BDT {{ number_format($waiting, 2) }}</strong></span>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @auth
                            <form method="POST" action="{{ route('investments.store', $project) }}">
                                @csrf
                                <label class="form-label">Investment Amount</label>
                                <input class="form-control form-control-lg" name="amount" type="number" min="{{ $project->minimum_investment }}" step="100" value="{{ old('amount', $project->minimum_investment) }}">
                                <label class="form-label mt-3">Note</label>
                                <textarea class="form-control" name="note" rows="3" placeholder="Optional instruction">{{ old('note') }}</textarea>
                                <button class="btn btn-primary w-100 mt-3" type="submit" @disabled(! $project->is_live)>Confirm Investment</button>
                            </form>
                        @else
                            <a class="btn btn-primary w-100" href="{{ route('login') }}">Login to Invest</a>
                            <a class="btn btn-outline-dark w-100 mt-2" href="{{ route('register') }}">Create Investor Account</a>
                        @endauth
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
