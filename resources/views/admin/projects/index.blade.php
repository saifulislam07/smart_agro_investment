@extends('layouts.app', ['title' => 'Manage Projects | GrowUp Agrotech'])

@section('content')
    <header class="page-hero compact">
        <div class="container d-flex justify-content-between align-items-center gap-3">
            <div>
                <span class="eyebrow">Admin</span>
                <h1 class="fw-bold mt-2 mb-0">Manage projects</h1>
            </div>
            <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">Create Project</a>
        </div>
    </header>
    <main class="section">
        <div class="container content-box">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Title</th><th>Status</th><th>ROI</th><th>Goal</th><th>Raised</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td><a class="fw-bold" href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></td>
                                <td>{{ $project->status }}</td>
                                <td>{{ $project->roi }}</td>
                                <td>BDT {{ number_format($project->goal) }}</td>
                                <td>BDT {{ number_format($project->raised) }}</td>
                                <td class="text-end">
                                    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                                    <form class="d-inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit" onclick="return confirm('Delete this project?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $projects->links() }}
        </div>
    </main>
@endsection
