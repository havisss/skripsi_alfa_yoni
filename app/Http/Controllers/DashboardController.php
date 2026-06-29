<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\QcHistory;
use App\Models\StockMutation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function stats()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalQcToday = QcHistory::whereDate('date', Carbon::today())->count();
        $totalPassed = QcHistory::where('status', 'OK')->count();
        $totalReject = QcHistory::where('status', 'Reject')->count();

        $qcChartData = [
            'labels' => ['Passed (OK)', 'Reject'],
            'data' => [$totalPassed, $totalReject]
        ];

        $latestQc = QcHistory::with('product')->orderBy('created_at', 'desc')->take(5)->get();
        $latestMutation = StockMutation::with('product')->orderBy('created_at', 'desc')->take(5)->get();

        return response()->json([
            'total_products' => $totalProducts,
            'total_stock' => $totalStock,
            'total_qc_today' => $totalQcToday,
            'total_passed' => $totalPassed,
            'total_reject' => $totalReject,
            'qc_chart_data' => $qcChartData,
            'latest_qc' => $latestQc,
            'latest_mutation' => $latestMutation
        ]);
    }
}
