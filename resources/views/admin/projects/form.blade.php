@extends('layouts.app', ['title' => ($project->exists ? 'Edit' : 'Create') . ' Project | Smart Agro'])

@section('content')
    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">Admin</span>
            <h1 class="fw-bold mt-2 mb-0">{{ $project->exists ? 'Edit project' : 'Create project' }}</h1>
        </div>
    </header>
    <main class="section">
        <div class="container content-box">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
                @csrf
                @if ($project->exists)
                    @method('PUT')
                @endif
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Title</label><input class="form-control" name="title" value="{{ old('title', $project->title) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Category</label><input class="form-control" name="category" value="{{ old('category', $project->category) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Business Type</label><input class="form-control" name="business_type" value="{{ old('business_type', $project->business_type) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Status</label><input class="form-control" name="status" value="{{ old('status', $project->status) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Investment Time</label><input class="form-control" name="investment_time" value="{{ old('investment_time', $project->investment_time) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Duration</label><input class="form-control" name="duration" value="{{ old('duration', $project->duration) }}" required></div>
                    <div class="col-md-3"><label class="form-label">ROI</label><input class="form-control" name="roi" value="{{ old('roi', $project->roi) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Start Date</label><input class="form-control" name="start_date" type="date" value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Mature Date</label><input class="form-control" name="mature_date" type="date" value="{{ old('mature_date', optional($project->mature_date)->format('Y-m-d')) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Goal</label><input class="form-control" name="goal" type="number" step="0.01" value="{{ old('goal', $project->goal) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Minimum Investment</label><input class="form-control" name="minimum_investment" type="number" step="0.01" value="{{ old('minimum_investment', $project->minimum_investment) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Raised</label><input class="form-control" name="raised" type="number" step="0.01" value="{{ old('raised', $project->raised) }}" required></div>
                    <div class="col-12"><label class="form-label">Image URL</label><input class="form-control" name="image" value="{{ old('image', $project->image) }}" required></div>
                    <div class="col-12"><label class="form-label">Summary</label><textarea class="form-control" name="summary" rows="3" required>{{ old('summary', $project->summary) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4">{{ old('description', $project->description) }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Market Opportunity</label><textarea class="form-control" name="market_opportunity" rows="4">{{ old('market_opportunity', $project->market_opportunity) }}</textarea></div>
                    <div class="col-md-6"><label class="form-label">Risk Factors</label><textarea class="form-control" name="risk_factors" rows="4">{{ old('risk_factors', $project->risk_factors) }}</textarea></div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="is_live" name="is_live" type="checkbox" value="1" @checked(old('is_live', $project->is_live))>
                            <label class="form-check-label" for="is_live">Open for investment</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">Save Project</button>
                    <a class="btn btn-outline-dark" href="{{ route('admin.projects.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </main>
@endsection

