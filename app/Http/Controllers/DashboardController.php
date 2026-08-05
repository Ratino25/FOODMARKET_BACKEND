<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransactions = \App\Models\Transaction::count();
        $totalUsers = \App\Models\User::where('roles', 'USER')->count();
        $totalFood = \App\Models\Food::count();
        $totalRevenue = \App\Models\Transaction::whereIn('status', ['SUCCESS', 'success', 'DELIVERED', 'delivered'])->sum('total');

        $statusCounts = \App\Models\Transaction::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('dashboard', compact(
            'totalTransactions',
            'totalUsers',
            'totalFood',
            'totalRevenue',
            'statusCounts'
        ));
    }
}
