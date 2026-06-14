@extends('layouts.admin', ['title' => 'Investment Report | Smart Agro Admin'])

@section('header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1 class="m-0">Investment Report</h1>
        </div>
        <div class="col-sm-4 text-right">
            <small class="text-muted">Generated: {{ now()->format('d M Y, h:i A') }}</small>
        </div>
    </div>
@endsection

@section('content')

    {{-- ===== SUMMARY CARDS ===== --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>{{ number_format($summary['total_investments']) }}</h3>
                    <p>Total Submissions</p>
                </div>
                <div class="icon"><i class="fas fa-layer-group"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $summary['total_investors'] }}</h3>
                    <p>Registered Investors</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($summary['total_amount'], 0) }}</h3>
                    <p>Total Invested (BDT)</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $summary['pending_count'] }}</h3>
                    <p>Pending Approvals</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
    </div>

    {{-- ===== STATUS BREAKDOWN ===== --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Status Breakdown</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Status</th>
                                <th class="text-center">Count</th>
                                <th class="text-right">Total Amount (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statuses = [
                                    ['pending',  'badge-warning',   'Pending',  $summary['pending_count'],  $summary['pending_amount']],
                                    ['active',   'badge-success',   'Active',   $summary['active_count'],   $summary['active_amount']],
                                    ['matured',  'badge-info',      'Matured',  $summary['matured_count'],  $summary['matured_amount']],
                                    ['rejected', 'badge-danger',    'Rejected', $summary['rejected_count'], $summary['rejected_amount']],
                                ];
                            @endphp
                            @foreach ($statuses as [$key, $badge, $label, $count, $amount])
                                <tr>
                                    <td><span class="badge {{ $badge }}">{{ $label }}</span></td>
                                    <td class="text-center">{{ number_format($count) }}</td>
                                    <td class="text-right">{{ number_format($amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bold table-light">
                                <td>Total</td>
                                <td class="text-center">{{ number_format($summary['total_investments']) }}</td>
                                <td class="text-right">{{ number_format($summary['total_amount'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-mobile-alt mr-2"></i>Payment Method Breakdown</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Method</th>
                                <th class="text-center">Count</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Pending</th>
                                <th class="text-right">Total (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($methodBreakdown as $row)
                                @php
                                    $icons = ['bkash' => '📱 bKash', 'nagad' => '📱 Nagad', 'bank' => '🏦 Bank'];
                                @endphp
                                <tr>
                                    <td>{{ $icons[$row->payment_method] ?? strtoupper($row->payment_method) }}</td>
                                    <td class="text-center">{{ $row->count }}</td>
                                    <td class="text-center"><span class="badge badge-success">{{ $row->active_count }}</span></td>
                                    <td class="text-center"><span class="badge badge-warning">{{ $row->pending_count }}</span></td>
                                    <td class="text-right">{{ number_format($row->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No payment data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PROJECT BREAKDOWN ===== --}}
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-boxes mr-2"></i>Per-Project Breakdown</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Project</th>
                        <th class="text-center">Total<br>Submissions</th>
                        <th class="text-center"><span class="badge badge-warning">Pending</span></th>
                        <th class="text-center"><span class="badge badge-success">Active</span></th>
                        <th class="text-center"><span class="badge badge-danger">Rejected</span></th>
                        <th class="text-right">Pending Amount</th>
                        <th class="text-right">Active Amount</th>
                        <th class="text-right">Total Amount</th>
                        <th class="text-right">Goal</th>
                        <th class="text-center">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projectBreakdown as $project)
                        @php
                            $progress = $project->goal > 0
                                ? min(100, round(($project->raised / $project->goal) * 100))
                                : 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $project->title }}</strong><br>
                                <small class="text-muted">{{ $project->category }}</small>
                            </td>
                            <td class="text-center">{{ $project->investments_count }}</td>
                            <td class="text-center">{{ $project->pending_count ?? 0 }}</td>
                            <td class="text-center">{{ $project->active_count ?? 0 }}</td>
                            <td class="text-center">{{ $project->rejected_count ?? 0 }}</td>
                            <td class="text-right">{{ number_format($project->pending_amount ?? 0, 2) }}</td>
                            <td class="text-right">{{ number_format($project->active_amount ?? 0, 2) }}</td>
                            <td class="text-right"><strong>{{ number_format($project->investments_sum_amount ?? 0, 2) }}</strong></td>
                            <td class="text-right">{{ number_format($project->goal, 2) }}</td>
                            <td class="text-center" style="min-width: 120px;">
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                </div>
                                <small>{{ $progress }}%</small>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-3">No investment data yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        {{-- ===== MONTHLY TREND ===== --}}
        <div class="col-md-7">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Monthly Investment Trend (Last 12 Months)</h3>
                </div>
                <div class="card-body p-0">
                    @if ($monthlyTrend->isEmpty())
                        <p class="text-center text-muted py-3">No data available.</p>
                    @else
                        <table class="table table-sm table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Month</th>
                                    <th class="text-center">Submissions</th>
                                    <th class="text-right">Amount (BDT)</th>
                                    <th style="width: 35%">Bar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxAmount = $monthlyTrend->max('total_amount') ?: 1; @endphp
                                @foreach ($monthlyTrend as $month)
                                    @php $barPct = round(($month['total_amount'] / $maxAmount) * 100); @endphp
                                    <tr>
                                        <td>{{ $month['label'] }}</td>
                                        <td class="text-center">{{ $month['count'] }}</td>
                                        <td class="text-right">{{ number_format($month['total_amount'], 0) }}</td>
                                        <td>
                                            <div class="progress progress-xs mt-1">
                                                <div class="progress-bar bg-primary" style="width: {{ $barPct }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== TOP INVESTORS ===== --}}
        <div class="col-md-5">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy mr-2"></i>Top Investors</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Investor</th>
                                <th class="text-center">Inv.</th>
                                <th class="text-right">Total (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topInvestors as $i => $investor)
                                <tr>
                                    <td>
                                        @if ($i === 0) 🥇
                                        @elseif ($i === 1) 🥈
                                        @elseif ($i === 2) 🥉
                                        @else {{ $i + 1 }}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $investor->name }}</strong><br>
                                        <small class="text-muted">{{ $investor->email }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.investments.index', ['search' => $investor->email]) }}"
                                            class="badge badge-info">{{ $investor->investments_count }}</a>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($investor->investments_sum_amount, 0) }}</strong>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== RECENT PENDING ===== --}}
    @if ($recentPending->isNotEmpty())
        <div class="card card-outline card-danger">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-hourglass-half mr-2"></i>
                    Pending — Awaiting Approval
                    <span class="badge badge-warning ml-1">{{ $recentPending->count() }}</span>
                </h3>
                <a href="{{ route('admin.investments.index', ['status' => 'pending']) }}"
                    class="btn btn-sm btn-warning">View All Pending</a>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Investor</th>
                            <th>Project</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Submitted</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentPending as $inv)
                            <tr>
                                <td>
                                    <strong>{{ $inv->user->name }}</strong><br>
                                    <small class="text-muted">{{ $inv->user->email }}</small>
                                </td>
                                <td>{{ $inv->project->title }}</td>
                                <td><strong>BDT {{ number_format($inv->amount, 2) }}</strong></td>
                                <td>
                                    @php $ml = ['bkash'=>'📱 bKash','nagad'=>'📱 Nagad','bank'=>'🏦 Bank']; @endphp
                                    <span class="badge badge-info">{{ $ml[$inv->payment_method] ?? '—' }}</span>
                                    @if ($inv->payment_date)
                                        <br><small>{{ $inv->payment_date->format('d M Y') }}</small>
                                    @endif
                                </td>
                                <td>{{ $inv->invested_at?->format('d M Y') }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.investments.index', ['status' => 'pending', 'search' => $inv->user->email]) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fas fa-check mr-1"></i> Approve
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
