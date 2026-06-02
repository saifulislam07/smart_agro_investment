<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Investment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless($request->user()->role === 'admin', 403);

        $summary = [
            'projects' => Project::count(),
            'users' => User::count(),
            'investments' => Investment::count(),
            'messages' => ContactMessage::count(),
            'raised' => Project::sum('raised'),
        ];

        $investments = Investment::with(['user', 'project'])->latest('invested_at')->take(10)->get();
        $messages = ContactMessage::latest()->take(8)->get();

        return view('admin.dashboard', compact('summary', 'investments', 'messages'));
    }
}
