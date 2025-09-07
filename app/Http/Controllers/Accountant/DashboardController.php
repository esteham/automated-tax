<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Taxpayer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'pendingFilings' => 0, // Replace with actual query for pending filings
            'totalTaxCollected' => 0, // Replace with actual query for total tax collected
            'recentPayments' => collect([]), // Replace with actual recent payments
        ];

        return view('accountant.dashboard', $data);
    }
}
