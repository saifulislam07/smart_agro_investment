<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Project;
use Illuminate\Http\Request;

class InvestmentController extends Controller {
    public function index(Request $request) {
        abort_unless($request->user()->role === 'admin', 403);

        $search  = $request->query('search');
        $status  = $request->query('status');
        $method  = $request->query('method');
        $project = $request->query('project');

        $investments = Investment::with(['user', 'project', 'approvedBy'])
            ->when($search, fn ($q) => $q->where(fn ($sub) =>
                $sub->whereHas('user', fn ($u) =>
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                )->orWhereHas('project', fn ($p) =>
                    $p->where('title', 'like', "%{$search}%")
                )
            ))
            ->when($status,  fn ($q) => $q->where('status', $status))
            ->when($method,  fn ($q) => $q->where('payment_method', $method))
            ->when($project, fn ($q) => $q->where('project_id', $project))
            ->latest('invested_at')
            ->paginate(20)
            ->withQueryString();

        $projects = Project::orderBy('title')->pluck('title', 'id');

        return view('admin.investments.index', compact('investments', 'projects'));
    }

    public function approve(Request $request, Investment $investment) {
        abort_unless($request->user()->role === 'admin', 403);

        if ($investment->status !== 'pending') {
            return back()->with('status', 'Investment has already been processed.');
        }

        $data = $request->validate([
            'approval_date' => ['required', 'date'],
        ]);

        $investment->status       = 'active';
        $investment->approved_by  = $request->user()->id;
        $investment->approval_date = $data['approval_date'];
        $investment->save();

        $investment->project->increment('raised', (float) $investment->amount);

        return back()->with('status', 'Investment approved successfully.');
    }

    public function reject(Request $request, Investment $investment) {
        abort_unless($request->user()->role === 'admin', 403);

        if ($investment->status !== 'pending') {
            return back()->with('error', 'Only pending investments can be rejected.');
        }

        $investment->status      = 'rejected';
        $investment->approved_by = $request->user()->id;
        $investment->approval_date = now()->toDateString();
        $investment->save();

        return back()->with('status', 'Investment rejected.');
    }
}
