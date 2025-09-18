<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
            'totalPermissions' => Permission::count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'totalTinRequests' => TinRequest::count(),
            'pendingTinRequests' => TinRequest::where('status', 'pending')->count(),
            'approvedTinRequests' => TinRequest::where('status', 'approved')->count(),
            'recentTinRequests' => TinRequest::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
