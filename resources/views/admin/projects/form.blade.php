@extends('layouts.admin', ['title' => ($project->exists ? 'Edit' : 'Create') . ' Project | Smart Agro Admin'])

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $project->exists ? 'Edit Project' : 'Create Project' }}</h1>
        </div>
        <div class="col-sm-6">
            <a class="btn btn-secondary float-right" href="{{ route('admin.projects.index') }}">
                <i class="fas fa-arrow-left mr-1"></i> Back to Projects
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
        action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
        @csrf
        @if ($project->exists)
            @method('PUT')
        @endif

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input class="form-control" name="title" value="{{ old('title', $project->title) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Category</label>
                        <input class="form-control" name="category" value="{{ old('category', $project->category) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Business Type</label>
                        <input class="form-control" name="business_type" value="{{ old('business_type', $project->business_type) }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Status</label>
                        <input class="form-control" name="status" value="{{ old('status', $project->status) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Investment Time</label>
                        <input class="form-control" name="investment_time" value="{{ old('investment_time', $project->investment_time) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Duration</label>
                        <input class="form-control" name="duration" value="{{ old('duration', $project->duration) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>ROI (%)</label>
                        <input class="form-control" name="roi" value="{{ old('roi', $project->roi) }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Start Date</label>
                        <input class="form-control" name="start_date" type="date"
                            value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Mature Date</label>
                        <input class="form-control" name="mature_date" type="date"
                            value="{{ old('mature_date', optional($project->mature_date)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Goal (BDT)</label>
                        <input class="form-control" name="goal" type="number" step="0.01"
                            value="{{ old('goal', $project->goal) }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Minimum Investment</label>
                        <input class="form-control" name="minimum_investment" type="number" step="0.01"
                            value="{{ old('minimum_investment', $project->minimum_investment) }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Raised (BDT)</label>
                        <input class="form-control" name="raised" type="number" step="0.01"
                            value="{{ old('raised', $project->raised) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input class="form-control" name="image" value="{{ old('image', $project->image) }}" required>
                </div>
                <div class="form-group">
                    <label>Summary</label>
                    <textarea class="form-control" name="summary" rows="3" required>{{ old('summary', $project->summary) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Market Opportunity</label>
                        <textarea class="form-control" name="market_opportunity" rows="4">{{ old('market_opportunity', $project->market_opportunity) }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Risk Factors</label>
                        <textarea class="form-control" name="risk_factors" rows="4">{{ old('risk_factors', $project->risk_factors) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_live" name="is_live"
                            value="1" @checked(old('is_live', $project->is_live))>
                        <label class="custom-control-label" for="is_live">Open for investment (Live)</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save mr-1"></i> Save Project
                </button>
                <a class="btn btn-secondary ml-2" href="{{ route('admin.projects.index') }}">Cancel</a>
            </div>
        </div>
    </form>
@endsection
