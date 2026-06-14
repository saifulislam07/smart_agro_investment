@extends('layouts.admin', ['title' => 'Manage Projects | Smart Agro Admin'])

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Projects</h1>
        </div>
        <div class="col-sm-6">
            <a class="btn btn-primary float-right" href="{{ route('admin.projects.create') }}">
                <i class="fas fa-plus mr-1"></i> Create Project
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">All Projects</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>ROI</th>
                        <th>Goal</th>
                        <th>Raised</th>
                        <th>Live</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <a class="font-weight-bold" href="{{ route('projects.show', $project) }}" target="_blank">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td><span class="badge badge-secondary">{{ $project->status }}</span></td>
                            <td>{{ $project->roi }}</td>
                            <td>BDT {{ number_format($project->goal) }}</td>
                            <td>BDT {{ number_format($project->raised) }}</td>
                            <td>
                                @if ($project->is_live)
                                    <span class="badge badge-success">Live</span>
                                @else
                                    <span class="badge badge-danger">Closed</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.projects.edit', $project) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form class="d-inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"
                                        onclick="return confirm('Delete this project?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $projects->links() }}
        </div>
    </div>
@endsection
