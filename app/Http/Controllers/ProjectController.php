<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('business_type'), fn ($query) => $query->where('business_type', $request->string('business_type')))
            ->when($request->string('sort')->toString() === 'roi', fn ($query) => $query->orderByDesc('roi'))
            ->when($request->string('sort')->toString() === 'goal', fn ($query) => $query->orderByDesc('goal'))
            ->when($request->string('sort')->toString() === 'start_date', fn ($query) => $query->orderByDesc('start_date'))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = Project::query()->distinct()->orderBy('category')->pluck('category');
        $statuses = Project::query()->distinct()->orderBy('status')->pluck('status');
        $businessTypes = Project::query()->distinct()->orderBy('business_type')->pluck('business_type');

        $quickStats = [
            'total' => Project::count(),
            'live' => Project::where('is_live', true)->count(),
            'raised' => Project::sum('raised'),
            'goal' => Project::sum('goal'),
        ];

        return view('projects.index', compact('projects', 'categories', 'statuses', 'businessTypes', 'quickStats'));
    }

    public function show(Project $project)
    {
        $relatedProjects = Project::query()
            ->whereKeyNot($project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
