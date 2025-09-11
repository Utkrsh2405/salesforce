<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Deal;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getDashboardStats();
        $chartData = $this->getChartData();
        $recentActivities = $this->getRecentActivities();
        $upcomingActivities = $this->getUpcomingActivities();
        $topDeals = $this->getTopDeals();
        $leadConversionData = $this->getLeadConversionData();

        dd($chartData); // Debugging statement to inspect $chartData structure

        return view('dashboard', compact(
            'stats', 
            'chartData', 
            'recentActivities', 
            'upcomingActivities', 
            'topDeals',
            'leadConversionData'
        ));
    }

    private function getDashboardStats()
    {
        $currentMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');

        return [
            'total_leads' => Lead::count(),
            'new_leads_this_month' => Lead::whereRaw("strftime('%Y-%m', created_at) = ?", [$currentMonth])->count(),
            'leads_growth' => $this->calculateGrowth(
                Lead::whereRaw("strftime('%Y-%m', created_at) = ?", [$lastMonth])->count(),
                Lead::whereRaw("strftime('%Y-%m', created_at) = ?", [$currentMonth])->count()
            ),
            
            'total_deals' => Deal::count(),
            'won_deals' => Deal::where('is_won', true)->count(),
            'deals_value' => Deal::where('is_won', false)->sum('deal_value'),
            'won_deals_value' => Deal::where('is_won', true)->sum('deal_value'),
            
            'total_contacts' => Contact::count(),
            'new_contacts_this_month' => Contact::whereRaw("strftime('%Y-%m', created_at) = ?", [$currentMonth])->count(),
            
            'total_companies' => Company::count(),
            'client_companies' => Company::where('is_client', true)->count(),
            
            'pending_activities' => Activity::where('is_completed', false)
                                           ->where('assigned_user_id', Auth::id())
                                           ->count(),
            'overdue_activities' => Activity::where('is_completed', false)
                                           ->where('assigned_user_id', Auth::id())
                                           ->where('due_date', '<', now())
                                           ->count(),
        ];
    }

    private function getChartData()
    {
        // Sales trend for last 7 days
        $salesData = [];
        $leadData = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M j');
            
            $salesData[] = Deal::whereDate('created_at', $date)->sum('deal_value');
            $leadData[] = Lead::whereDate('created_at', $date)->count();
        }

        // Ensure labels are always defined
        $labels = $labels ?? [];

        // Deal stages distribution
        $dealStages = DB::table('deal_stages')
            ->leftJoin('deals', function($join) {
                $join->on('deal_stages.id', '=', 'deals.deal_stage_id')
                     ->where('deals.is_won', false);
            })
            ->select('deal_stages.name', DB::raw('COUNT(deals.id) as count'), 'deal_stages.color')
            ->groupBy('deal_stages.id', 'deal_stages.name', 'deal_stages.color')
            ->get();

        return [
            'sales_trend' => [
                'labels' => $labels,
                'sales_data' => $salesData,
                'lead_data' => $leadData,
            ],
            'deal_stages' => [
                'labels' => $dealStages->pluck('name'),
                'data' => $dealStages->pluck('count'),
                'colors' => $dealStages->pluck('color'),
            ]
        ];
    }

    private function getRecentActivities()
    {
        return Activity::with(['assignedUser'])
            ->where('assigned_user_id', Auth::id())
            ->where('is_completed', true)
            ->latest('completed_at')
            ->limit(5)
            ->get();
    }

    private function getUpcomingActivities()
    {
        return Activity::with(['assignedUser'])
            ->where('assigned_user_id', Auth::id())
            ->where('is_completed', false)
            ->where('due_date', '>=', now())
            ->orderBy('due_date')
            ->limit(5)
            ->get();
    }

    private function getTopDeals()
    {
        return Deal::with(['company', 'assignedUser', 'dealStage'])
            ->where('is_won', false)
            ->orderBy('deal_value', 'desc')
            ->limit(5)
            ->get();
    }

    private function getLeadConversionData()
    {
        $totalLeads = Lead::count();
        $convertedLeads = Lead::whereNotNull('conversion_date')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;

        return [
            'total_leads' => $totalLeads,
            'converted_leads' => $convertedLeads,
            'conversion_rate' => $conversionRate,
        ];
    }

    private function calculateGrowth($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }
}
