<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\WaterLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
class DashboardController extends Controller
{

    public function __construct()
    {
        // Apply middleware to all methods in this controller
        $this->middleware(['verified', 'permission:read dashboard']);
    }

    public function index(Request $request)
    {
        $filterType = $request->input('filter', 'month'); // Default to 'month'
        $selectedMonth = $request->input('month', Carbon::now()->month); // Default to current month

        if ($filterType === 'today') {
            // Get water levels for today
            $waterLevels = WaterLevel::whereDate('measured_at', Carbon::today())->pluck('level');
            $labels = WaterLevel::whereDate('measured_at', Carbon::today())->pluck('measured_at');
        } else {
            // Get water levels for the selected month
            $waterLevels = WaterLevel::whereMonth('measured_at', $selectedMonth)->pluck('level');
            $labels = WaterLevel::whereMonth('measured_at', $selectedMonth)->pluck('measured_at');
        }

        return Inertia::render('Dashboard', [
            'waterLevels' => $waterLevels,
            'labels' => $labels,
            'selectedMonth' => $selectedMonth,
            'filterType' => $filterType,
        ]);


    }
}