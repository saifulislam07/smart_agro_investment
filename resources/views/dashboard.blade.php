@extends('layouts.app', ['title' => 'Investor Dashboard | Smart Agro'])

@section('content')
    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">Investor Dashboard</span>
            <h1 class="fw-bold mt-2 mb-0">Welcome, {{ auth()->user()->name }}</h1>
        </div>
    </header>

    <main class="section">
        <div class="container">
            <div class="dashboard-grid mb-4">
                <div class="dash-card"><span>Total Invested</span><strong>BDT {{ number_format($summary['total_invested'], 2) }}</strong></div>
                <div class="dash-card"><span>Current Value</span><strong>BDT {{ number_format($summary['current_value'], 2) }}</strong></div>
                <div class="dash-card"><span>Expected Returns</span><strong>BDT {{ number_format($summary['total_returns'], 2) }}</strong></div>
                <div class="dash-card"><span>Active Investments</span><strong>{{ $summary['active_count'] }}</strong></div>
            </div>

            <div class="content-box">
                <div class="section-head mb-3">
                    <div>
                        <span class="eyebrow">Portfolio</span>
                        <h2 class="h4 fw-bold mt-2">Active Investments</h2>
                    </div>
                    <a class="btn btn-primary" href="{{ route('projects.index') }}">Explore Projects</a>
                </div>

                @if ($investments->isEmpty())
                    <div class="empty-state">No investment submitted yet. Explore live projects and submit your first amount.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Amount</th>
                                    <th>Expected Return</th>
                                    <th>Maturity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investments as $investment)
                                    <tr>
                                        <td><a class="fw-bold" href="{{ route('projects.show', $investment->project) }}">{{ $investment->project->title }}</a></td>
                                        <td>BDT {{ number_format($investment->amount, 2) }}</td>
                                        <td>BDT {{ number_format($investment->expected_return, 2) }}</td>
                                        <td>{{ $investment->matured_at?->format('d M Y') }}</td>
                                        <td><span class="badge bg-success-subtle text-success">{{ ucfirst($investment->status) }}</span></td>
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

