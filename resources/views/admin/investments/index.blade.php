@extends('layouts.admin', ['title' => 'Manage Investments | Smart Agro Admin'])

@php
    function adminInvestmentBadge(string $status): string {
        return match($status) {
            'pending'  => 'badge-warning',
            'active'   => 'badge-success',
            'matured'  => 'badge-info',
            'rejected' => 'badge-danger',
            default    => 'badge-secondary',
        };
    }
@endphp

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Investment Approvals</h1>
        </div>
    </div>
@endsection

@section('content')

    {{-- Search / filter card --}}
    <div class="card card-outline card-secondary mb-3">
        <div class="card-body pb-0">
            <form method="GET" action="{{ route('admin.investments.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4">
                        <label class="small font-weight-bold">Search investor / project</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" name="search"
                                value="{{ request('search') }}"
                                placeholder="Name, email or project…">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="small font-weight-bold">Status</label>
                        <select class="form-control" name="status">
                            <option value="">All Status</option>
                            <option value="pending"  @selected(request('status') === 'pending')>Pending</option>
                            <option value="active"   @selected(request('status') === 'active')>Active</option>
                            <option value="matured"  @selected(request('status') === 'matured')>Matured</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="small font-weight-bold">Payment Method</label>
                        <select class="form-control" name="method">
                            <option value="">All Methods</option>
                            <option value="bkash" @selected(request('method') === 'bkash')>bKash</option>
                            <option value="nagad" @selected(request('method') === 'nagad')>Nagad</option>
                            <option value="bank"  @selected(request('method') === 'bank')>Bank</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small font-weight-bold">Project</label>
                        <select class="form-control" name="project">
                            <option value="">All Projects</option>
                            @foreach ($projects as $id => $title)
                                <option value="{{ $id }}" @selected(request('project') == $id)>{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <button class="btn btn-primary btn-block" type="submit">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
                @if (request()->hasAny(['search', 'status', 'method', 'project']))
                    <a href="{{ route('admin.investments.index') }}" class="small text-muted d-inline-block mb-2">
                        <i class="fas fa-times-circle mr-1"></i>Clear filters
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Status legend --}}
    <div class="mb-3">
        <span class="badge badge-warning mr-1">Pending</span> awaiting verification &nbsp;
        <span class="badge badge-success mr-1">Active</span> approved &nbsp;
        <span class="badge badge-info mr-1">Matured</span> completed &nbsp;
        <span class="badge badge-danger mr-1">Rejected</span> declined
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                Investment Submissions
                <span class="badge badge-secondary ml-2">{{ $investments->total() }}</span>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Investor</th>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>Payment Details</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Approved By</th>
                        <th>Approval Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($investments as $investment)
                        <tr>
                            <td>{{ $loop->iteration + ($investments->currentPage() - 1) * $investments->perPage() }}</td>
                            <td>
                                <strong>{{ $investment->user->name }}</strong><br>
                                <small class="text-muted">{{ $investment->user->email }}</small>
                            </td>
                            <td>{{ $investment->project->title }}</td>
                            <td>
                                <strong>BDT {{ number_format($investment->amount, 2) }}</strong><br>
                                <small class="text-muted">Return: {{ number_format($investment->expected_return, 2) }}</small>
                            </td>
                            <td style="min-width: 190px;">
                                @php
                                    $methodLabels = ['bkash' => '📱 bKash', 'nagad' => '📱 Nagad', 'bank' => '🏦 Bank'];
                                    $methodLabel  = $methodLabels[$investment->payment_method] ?? strtoupper($investment->payment_method ?? '-');
                                @endphp
                                <span class="badge badge-info">{{ $methodLabel }}</span><br>

                                @if ($investment->payment_method === 'bank' && $investment->payment_bank_name)
                                    <small><i class="fas fa-university mr-1"></i>{{ $investment->payment_bank_name }}</small><br>
                                @endif

                                <small><i class="fas fa-hashtag mr-1"></i><strong>A/C:</strong> {{ $investment->payment_account_number ?? '-' }}</small><br>

                                @if ($investment->payment_reference)
                                    <small><i class="fas fa-receipt mr-1"></i><strong>Ref:</strong> {{ $investment->payment_reference }}</small><br>
                                @endif

                                <small><i class="fas fa-calendar-alt mr-1"></i><strong>Date:</strong> {{ $investment->payment_date?->format('d M Y') ?? '-' }}</small>

                                @if ($investment->note)
                                    <br><small class="text-muted"><i class="fas fa-comment mr-1"></i>{{ Str::limit($investment->note, 60) }}</small>
                                @endif
                            </td>
                            <td>{{ $investment->invested_at?->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ adminInvestmentBadge($investment->status) }}">
                                    {{ ucfirst($investment->status) }}
                                </span>
                            </td>
                            <td>{{ $investment->approvedBy?->name ?? '-' }}</td>
                            <td>{{ $investment->approval_date?->format('d M Y') ?? '-' }}</td>
                            <td class="text-right" style="min-width: 200px;">
                                @if ($investment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.investments.approve', $investment) }}" class="mb-1">
                                        @csrf
                                        <div class="input-group input-group-sm mb-1">
                                            <input type="date" name="approval_date" class="form-control form-control-sm"
                                                value="{{ now()->toDateString() }}" required>
                                        </div>
                                        <button class="btn btn-sm btn-success btn-block" type="submit">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.investments.reject', $investment) }}"
                                        onsubmit="return confirm('Reject this investment?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger btn-block" type="submit">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-{{ $investment->status === 'rejected' ? 'times-circle text-danger' : 'check-circle text-success' }} mr-1"></i>
                                        {{ ucfirst($investment->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                @if (request()->hasAny(['search', 'status', 'method', 'project']))
                                    No results match your filter. <a href="{{ route('admin.investments.index') }}">Clear filters</a>
                                @else
                                    No investment submissions yet.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $investments->links() }}
        </div>
    </div>
@endsection
