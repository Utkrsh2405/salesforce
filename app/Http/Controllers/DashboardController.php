<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $chartData = $this->getChartData();
        return view('dashboard', compact('chartData'));
    }

    private function getChartData()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M d');
            $data[] = \App\Models\Activity::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
