@extends('layouts.admin', ['title' => 'Registered Users | Smart Agro Admin'])

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Registered Users</h1>
        </div>
    </div>
@endsection

@section('content')

    {{-- Search / filter --}}
    <div class="card card-outline card-secondary mb-3">
        <div class="card-body pb-0">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-6">
                        <label class="small font-weight-bold">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" name="search"
                                value="{{ request('search') }}"
                                placeholder="Name, email or phone…">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small font-weight-bold">Role</label>
                        <select class="form-control" name="role">
                            <option value="">All Roles</option>
                            <option value="investor" @selected(request('role') === 'investor')>Investor</option>
                            <option value="admin"    @selected(request('role') === 'admin')>Admin</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-primary btn-block" type="submit">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                    <div class="form-group col-md-1">
                        @if (request()->hasAny(['search', 'role']))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-block" title="Clear">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                All Users
                <span class="badge badge-secondary ml-2">{{ $users->total() }}</span>
            </h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Verified</th>
                        <th>Investments</th>
                        <th>Total Invested</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </td>
                            <td>{{ $user->phone ?? '—' }}</td>
                            <td>
                                <span title="{{ $user->address }}">
                                    {{ $user->address ? Str::limit($user->address, 30) : '—' }}
                                </span>
                            </td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge badge-danger">Admin</span>
                                @else
                                    <span class="badge badge-primary">Investor</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->is_verified)
                                    <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Yes</span>
                                @else
                                    <span class="badge badge-warning text-dark"><i class="fas fa-clock mr-1"></i>No</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($user->investments_count > 0)
                                    <a href="{{ route('admin.investments.index', ['search' => $user->email]) }}"
                                        class="badge badge-info">
                                        {{ $user->investments_count }}
                                    </a>
                                @else
                                    <span class="text-muted">0</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->investments_sum_amount)
                                    <strong>BDT {{ number_format($user->investments_sum_amount, 2) }}</strong>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                @if (request()->hasAny(['search', 'role']))
                                    No users match your filter.
                                    <a href="{{ route('admin.users.index') }}">Clear filters</a>
                                @else
                                    No registered users yet.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $users->links() }}
        </div>
    </div>
@endsection
