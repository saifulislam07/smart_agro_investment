<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $investments = $request->user()
            ->investments()
            ->with('project')
            ->latest('invested_at')
            ->get();

        $summary = [
            'total_invested' => $investments->sum(fn ($investment) => (float) $investment->amount),
            'current_value' => $investments->sum(fn ($investment) => (float) $investment->expected_return),
            'total_returns' => $investments->sum(fn ($investment) => (float) $investment->expected_return - (float) $investment->amount),
            'active_count' => $investments->where('status', 'active')->count(),
        ];

        return view('dashboard', compact('investments', 'summary'));
    }
}
