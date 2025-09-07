<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TaxFiling;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalAudits' => 0, // Replace with actual query for total audits
            'pendingReviews' => 0, // Replace with actual query for pending reviews
            'recentAudits' => collect([]), // Replace with actual recent audits
        ];

        return view('auditor.dashboard', $data);
    }
}
