<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $projects = Project::latest()->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $this->authorizeAdmin($request);

        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        Project::create($this->validated($request));

        return redirect()->route('admin.projects.index')->with('status', 'Project created successfully.');
    }

    public function edit(Request $request, Project $project)
    {
        $this->authorizeAdmin($request);

        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeAdmin($request);

        $project->update($this->validated($request, $project));

        return redirect()->route('admin.projects.index')->with('status', 'Project updated successfully.');
    }

    public function destroy(Request $request, Project $project)
    {
        $this->authorizeAdmin($request);

        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted successfully.');
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()->role === 'admin', 403);
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'business_type' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'investment_time' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'mature_date' => ['required', 'date', 'after_or_equal:start_date'],
            'goal' => ['required', 'numeric', 'min:0'],
            'minimum_investment' => ['required', 'numeric', 'min:0'],
            'raised' => ['required', 'numeric', 'min:0'],
            'roi' => ['required', 'string', 'max:255'],
            'image' => ['required', 'url'],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'market_opportunity' => ['nullable', 'string'],
            'risk_factors' => ['nullable', 'string'],
            'is_live' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($data['title']);
        if ($project && $project->exists && $project->slug === $slug) {
            $data['slug'] = $project->slug;
        } else {
            $base = $slug;
            $counter = 2;
            while (Project::where('slug', $slug)->when($project?->exists, fn ($query) => $query->whereKeyNot($project->id))->exists()) {
                $slug = $base . '-' . $counter++;
            }
            $data['slug'] = $slug;
        }

        $data['is_live'] = $request->boolean('is_live');
        $data['gallery'] = [$data['image']];

        return $data;
    }
}
