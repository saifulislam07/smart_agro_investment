@extends('layouts.app', ['title' => 'Investor Dashboard | Smart Agro'])

@php
    function investmentBadge(string $status): string {
        return match($status) {
            'pending'  => 'bg-warning text-dark',
            'active'   => 'bg-success text-white',
            'matured'  => 'bg-info text-white',
            'rejected' => 'bg-danger text-white',
            default    => 'bg-secondary text-white',
        };
    }
@endphp

@section('content')
    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">Investor Dashboard</span>
            <h1 class="fw-bold mt-2 mb-0">Welcome, {{ auth()->user()->name }}</h1>
        </div>
    </header>

    <main class="section">
        <div class="container">
            {{-- Summary cards --}}
            <div class="dashboard-grid mb-4">
                <div class="dash-card"><span>Total Invested</span><strong>BDT {{ number_format($summary['total_invested'], 2) }}</strong></div>
                <div class="dash-card"><span>Current Value</span><strong>BDT {{ number_format($summary['current_value'], 2) }}</strong></div>
                <div class="dash-card"><span>Expected Returns</span><strong>BDT {{ number_format($summary['total_returns'], 2) }}</strong></div>
                <div class="dash-card"><span>Active Investments</span><strong>{{ $summary['active_count'] }}</strong></div>
            </div>

            <div class="content-box">
                {{-- Header + search --}}
                <div class="section-head mb-3">
                    <div>
                        <span class="eyebrow">Portfolio</span>
                        <h2 class="h4 fw-bold mt-2 mb-0">My Investments</h2>
                    </div>
                    <a class="btn btn-primary" href="{{ route('projects.index') }}">Explore Projects</a>
                </div>

                {{-- Search / filter bar --}}
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 mb-4">
                    <div class="col-sm-7 col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by project name…">
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2">
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="pending"  @selected(request('status') === 'pending')>Pending</option>
                            <option value="active"   @selected(request('status') === 'active')>Active</option>
                            <option value="matured"  @selected(request('status') === 'matured')>Matured</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
                    </div>
                    @if (request('search') || request('status'))
                        <div class="col-12">
                            <a href="{{ route('dashboard') }}" class="small text-muted">
                                <i class="bi bi-x-circle me-1"></i>Clear filters
                            </a>
                        </div>
                    @endif
                </form>

                {{-- Legend --}}
                <div class="d-flex flex-wrap gap-2 mb-3 small">
                    <span class="badge bg-warning text-dark">Pending — awaiting admin approval</span>
                    <span class="badge bg-success text-white">Active — approved &amp; running</span>
                    <span class="badge bg-info text-white">Matured — completed</span>
                    <span class="badge bg-danger text-white">Rejected</span>
                </div>

                @if ($investments->isEmpty())
                    <div class="empty-state">
                        @if (request('search') || request('status'))
                            No investments match your filter.
                            <a href="{{ route('dashboard') }}">Clear filters</a>
                        @else
                            No investment submitted yet. Explore live projects and submit your first amount.
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Amount</th>
                                    <th>Expected Return</th>
                                    <th>Payment</th>
                                    <th>Submitted</th>
                                    <th>Maturity</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investments as $investment)
                                    <tr>
                                        <td>
                                            <a class="fw-bold" href="{{ route('projects.show', $investment->project) }}">
                                                {{ $investment->project->title }}
                                            </a>
                                        </td>
                                        <td>BDT {{ number_format($investment->amount, 2) }}</td>
                                        <td>BDT {{ number_format($investment->expected_return, 2) }}</td>
                                        <td>
                                            @if ($investment->payment_method)
                                                <span class="badge bg-light text-dark border">
                                                    {{ strtoupper($investment->payment_method) }}
                                                </span><br>
                                                <small class="text-muted">{{ $investment->payment_date?->format('d M Y') }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $investment->invested_at?->format('d M Y') }}</td>
                                        <td>{{ $investment->matured_at?->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge {{ investmentBadge($investment->status) }}">
                                                {{ ucfirst($investment->status) }}
                                            </span>
                                            @if ($investment->status === 'pending')
                                                <br><small class="text-muted">Awaiting approval</small>
                                            @elseif ($investment->status === 'active' && $investment->approval_date)
                                                <br><small class="text-muted">Approved {{ $investment->approval_date->format('d M Y') }}</small>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if ($investment->status === 'pending')
                                                <a class="btn btn-sm btn-outline-warning"
                                                    href="{{ route('investments.edit', $investment) }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
