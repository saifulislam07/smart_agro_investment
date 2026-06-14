<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index(Request $request) {
        abort_unless($request->user()->role === 'admin', 403);

        $search = $request->query('search');
        $role   = $request->query('role');

        $users = User::withCount('investments')
            ->withSum('investments', 'amount')
            ->when($search, fn ($q) => $q->where(fn ($sub) =>
                $sub->where('name',  'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
            ))
            ->when($role, fn ($q) => $q->where('role', $role))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }
}
