<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $investments = $request->user()
            ->investments()
            ->with('project')
            ->when($search, fn ($q) => $q->whereHas(
                'project',
                fn ($q2) => $q2->where('title', 'like', "%{$search}%")
            ))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest('invested_at')
            ->get();

        $allInvestments = $request->user()->investments;

        $summary = [
            'total_invested' => $allInvestments->sum(fn ($i) => (float) $i->amount),
            'current_value'  => $allInvestments->sum(fn ($i) => (float) $i->expected_return),
            'total_returns'  => $allInvestments->sum(fn ($i) => (float) $i->expected_return - (float) $i->amount),
            'active_count'   => $allInvestments->where('status', 'active')->count(),
        ];

        return view('dashboard', compact('investments', 'summary'));
    }
}
