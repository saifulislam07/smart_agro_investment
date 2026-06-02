<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:' . (float) $project->minimum_investment],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        if (! $project->is_live) {
            return back()->withErrors(['amount' => 'This project is not currently open for investment.']);
        }

        $roi = (float) filter_var($project->roi, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $expectedReturn = (float) $data['amount'] + ((float) $data['amount'] * ($roi / 100));

        Investment::create([
            'user_id' => $request->user()->id,
            'project_id' => $project->id,
            'amount' => $data['amount'],
            'expected_return' => $expectedReturn,
            'invested_at' => now(),
            'matured_at' => $project->mature_date,
            'status' => 'active',
            'note' => $data['note'] ?? null,
        ]);

        $project->increment('raised', (float) $data['amount']);

        return redirect()->route('dashboard')->with('status', 'Investment submitted successfully.');
    }
}
