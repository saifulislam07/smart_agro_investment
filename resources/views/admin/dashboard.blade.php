@extends('layouts.app', ['title' => 'Admin Dashboard | GrowUp Agrotech'])

@section('content')
    <header class="page-hero compact">
        <div class="container">
            <span class="eyebrow">Admin</span>
            <h1 class="fw-bold mt-2 mb-0">Operations dashboard</h1>
        </div>
    </header>
    <main class="section">
        <div class="container">
            <div class="dashboard-grid mb-4">
                <div class="dash-card"><span>Projects</span><strong>{{ $summary['projects'] }}</strong></div>
                <div class="dash-card"><span>Users</span><strong>{{ $summary['users'] }}</strong></div>
                <div class="dash-card"><span>Investments</span><strong>{{ $summary['investments'] }}</strong></div>
                <div class="dash-card"><span>Raised</span><strong>BDT {{ number_format($summary['raised']) }}</strong></div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="content-box">
                        <div class="section-head mb-3">
                            <div>
                                <span class="eyebrow">Review</span>
                                <h2 class="h4 fw-bold mt-2">Recent Investments</h2>
                            </div>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Manage Projects</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead><tr><th>Investor</th><th>Project</th><th>Amount</th><th>Status</th></tr></thead>
                                <tbody>
                                    @foreach ($investments as $investment)
                                        <tr>
                                            <td>{{ $investment->user->name }}</td>
                                            <td>{{ $investment->project->title }}</td>
                                            <td>BDT {{ number_format($investment->amount, 2) }}</td>
                                            <td><span class="badge bg-success-subtle text-success">{{ ucfirst($investment->status) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="content-box">
                        <span class="eyebrow">Contact Messages</span>
                        <h2 class="h4 fw-bold mt-2 mb-3">{{ $summary['messages'] }} messages</h2>
                        @forelse ($messages as $message)
                            <div class="message-item">
                                <strong>{{ $message->subject }}</strong>
                                <span>{{ $message->name }} · {{ $message->email }}</span>
                                <p>{{ $message->message }}</p>
                            </div>
                        @empty
                            <div class="empty-state">No contact messages yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
