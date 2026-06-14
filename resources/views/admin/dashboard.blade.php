@extends('layouts.admin', ['title' => 'Admin Dashboard | Smart Agro'])

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $summary['projects'] }}</h3>
                    <p>Projects</p>
                </div>
                <div class="icon"><i class="fas fa-boxes"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $summary['users'] }}</h3>
                    <p>Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $summary['investments'] }}</h3>
                    <p>Total Investments</p>
                </div>
                <div class="icon"><i class="fas fa-hand-holding-dollar"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $summary['pending_investments'] }}</h3>
                    <p>Pending Approvals</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Recent Investment Submissions</h3>
                    <a href="{{ route('admin.investments.index') }}" class="btn btn-sm btn-primary">View All Investments</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Investor</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Approved By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($investments as $investment)
                                <tr>
                                    <td>{{ $investment->user->name }}</td>
                                    <td>{{ $investment->project->title }}</td>
                                    <td>BDT {{ number_format($investment->amount, 2) }}</td>
                                    <td><span
                                            class="badge bg-{{ $investment->status === 'pending' ? 'warning' : 'success' }}">{{ ucfirst($investment->status) }}</span>
                                    </td>
                                    <td>{{ $investment->approvedBy?->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Recent Investments</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Investor</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($investments as $investment)
                                <tr>
                                    <td>{{ $investment->user->name }}</td>
                                    <td>{{ $investment->project->title }}</td>
                                    <td>BDT {{ number_format($investment->amount, 2) }}</td>
                                    <td><span
                                            class="badge bg-{{ $investment->status === 'pending' ? 'warning' : 'success' }}">{{ ucfirst($investment->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Contact Messages</h3>
                </div>
                <div class="card-body">
                    @forelse ($messages as $message)
                        <div class="mb-3">
                            <strong>{{ $message->subject }}</strong>
                            <div class="text-muted">{{ $message->name }} · {{ $message->email }}</div>
                            <p class="mb-0">{{ $message->message }}</p>
                        </div>
                    @empty
                        <div class="text-muted">No contact messages yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
