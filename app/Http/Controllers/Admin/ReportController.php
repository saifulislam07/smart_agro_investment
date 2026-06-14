<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    public function investments(Request $request) {
        abort_unless($request->user()->role === 'admin', 403);

        // Overall summary
        $summary = [
            'total_investors'    => User::where('role', 'investor')->count(),
            'total_investments'  => Investment::count(),
            'total_amount'       => Investment::sum('amount'),
            'total_expected'     => Investment::sum('expected_return'),
            'pending_count'      => Investment::where('status', 'pending')->count(),
            'pending_amount'     => Investment::where('status', 'pending')->sum('amount'),
            'active_count'       => Investment::where('status', 'active')->count(),
            'active_amount'      => Investment::where('status', 'active')->sum('amount'),
            'matured_count'      => Investment::where('status', 'matured')->count(),
            'matured_amount'     => Investment::where('status', 'matured')->sum('amount'),
            'rejected_count'     => Investment::where('status', 'rejected')->count(),
            'rejected_amount'    => Investment::where('status', 'rejected')->sum('amount'),
        ];

        // Per-project breakdown
        $projectBreakdown = Project::withCount([
                'investments',
                'investments as pending_count'  => fn ($q) => $q->where('status', 'pending'),
                'investments as active_count'   => fn ($q) => $q->where('status', 'active'),
                'investments as rejected_count' => fn ($q) => $q->where('status', 'rejected'),
            ])
            ->withSum('investments', 'amount')
            ->withSum(['investments as active_amount' => fn ($q) => $q->where('status', 'active')], 'amount')
            ->withSum(['investments as pending_amount' => fn ($q) => $q->where('status', 'pending')], 'amount')
            ->having('investments_count', '>', 0)
            ->orderByDesc('investments_sum_amount')
            ->get();

        // Per-payment-method breakdown
        $methodBreakdown = Investment::select('payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active_count'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count')
            )
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->orderByDesc('total_amount')
            ->get();

        // Monthly investment trend (last 12 months)
        $monthlyTrend = Investment::select(
                DB::raw('YEAR(invested_at) as year'),
                DB::raw('MONTH(invested_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('invested_at', '>=', now()->subMonths(12)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(fn ($row) => [
                'label'        => date('M Y', mktime(0, 0, 0, $row->month, 1, $row->year)),
                'count'        => $row->count,
                'total_amount' => $row->total_amount,
            ]);

        // Top investors
        $topInvestors = User::withCount('investments')
            ->withSum('investments', 'amount')
            ->withSum(['investments as active_amount' => fn ($q) => $q->where('status', 'active')], 'amount')
            ->where('role', 'investor')
            ->having('investments_count', '>', 0)
            ->orderByDesc('investments_sum_amount')
            ->take(10)
            ->get();

        // Recent pending investments
        $recentPending = Investment::with(['user', 'project'])
            ->where('status', 'pending')
            ->latest('invested_at')
            ->take(10)
            ->get();

        return view('admin.reports.investments', compact(
            'summary', 'projectBreakdown', 'methodBreakdown',
            'monthlyTrend', 'topInvestors', 'recentPending'
        ));
    }
}
