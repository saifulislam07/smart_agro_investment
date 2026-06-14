<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use Illuminate\Http\Request;

class InvestmentController extends Controller {
    public function store(Request $request, Project $project) {
        $data = $request->validate([
            'amount'                 => ['required', 'numeric', 'min:' . (float) $project->minimum_investment],
            'payment_method'         => ['required', 'string', 'in:bkash,nagad,bank'],
            'payment_account_number' => ['required', 'string', 'max:255'],
            'payment_bank_name'      => ['required_if:payment_method,bank', 'nullable', 'string', 'max:255'],
            'payment_reference'      => ['nullable', 'string', 'max:1000'],
            'payment_date'           => ['required', 'date'],
            'note'                   => ['nullable', 'string', 'max:1000'],
        ]);

        if (! $project->is_live) {
            return back()->withErrors(['amount' => 'This project is not currently open for investment.']);
        }

        $roi = (float) filter_var($project->roi, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $expectedReturn = (float) $data['amount'] + ((float) $data['amount'] * ($roi / 100));

        Investment::create([
            'user_id'                => $request->user()->id,
            'project_id'             => $project->id,
            'amount'                 => $data['amount'],
            'payment_method'         => $data['payment_method'],
            'payment_account_number' => $data['payment_account_number'],
            'payment_bank_name'      => $data['payment_bank_name'] ?? null,
            'payment_reference'      => $data['payment_reference'] ?? null,
            'payment_date'           => $data['payment_date'],
            'expected_return'        => $expectedReturn,
            'invested_at'            => now(),
            'matured_at'             => $project->mature_date,
            'status'                 => 'pending',
            'note'                   => $data['note'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('status', 'Investment submitted successfully. It will be confirmed after admin verification.');
    }

    public function edit(Request $request, Investment $investment) {
        abort_unless($investment->user_id === $request->user()->id, 403);
        abort_unless($investment->status === 'pending', 403, 'Only pending investments can be edited.');

        $investment->load('project');
        return view('investments.edit', compact('investment'));
    }

    public function update(Request $request, Investment $investment) {
        abort_unless($investment->user_id === $request->user()->id, 403);
        abort_unless($investment->status === 'pending', 403, 'Only pending investments can be edited.');

        $project = $investment->project;

        $data = $request->validate([
            'amount'                 => ['required', 'numeric', 'min:' . (float) $project->minimum_investment],
            'payment_method'         => ['required', 'string', 'in:bkash,nagad,bank'],
            'payment_account_number' => ['required', 'string', 'max:255'],
            'payment_bank_name'      => ['required_if:payment_method,bank', 'nullable', 'string', 'max:255'],
            'payment_reference'      => ['nullable', 'string', 'max:1000'],
            'payment_date'           => ['required', 'date'],
            'note'                   => ['nullable', 'string', 'max:1000'],
        ]);

        $roi = (float) filter_var($project->roi, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $expectedReturn = (float) $data['amount'] + ((float) $data['amount'] * ($roi / 100));

        $investment->update([
            'amount'                 => $data['amount'],
            'payment_method'         => $data['payment_method'],
            'payment_account_number' => $data['payment_account_number'],
            'payment_bank_name'      => $data['payment_bank_name'] ?? null,
            'payment_reference'      => $data['payment_reference'] ?? null,
            'payment_date'           => $data['payment_date'],
            'expected_return'        => $expectedReturn,
            'note'                   => $data['note'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('status', 'Investment updated successfully.');
    }
}
