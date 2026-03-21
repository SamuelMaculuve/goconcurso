<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ContestInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $company = Auth::user()->company()->firstOrFail();

        $totalContests = Contest::where('company_id', $company->id)->count();

        $totalInterests = ContestInterest::whereHas('contest', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();

        $totalApplications = ContestApplication::whereHas('contest', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();

        $recentContests = Contest::where('company_id', $company->id)
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        $topViewedContests = Contest::where('company_id', $company->id)
            ->with('category')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        return view('company.dashboard', compact(
            'company',
            'totalContests',
            'totalInterests',
            'totalApplications',
            'recentContests',
            'topViewedContests'
        ));
    }

    public function statistics(): View
    {
        $company = Auth::user()->company()->firstOrFail();

        $totalContests     = Contest::where('company_id', $company->id)->count();
        $totalViews        = Contest::where('company_id', $company->id)->sum('views_count');
        $totalInterests    = ContestInterest::whereHas('contest', fn ($q) => $q->where('company_id', $company->id))->count();
        $totalApplications = ContestApplication::whereHas('contest', fn ($q) => $q->where('company_id', $company->id))->count();

        $contestsByStatus = Contest::where('company_id', $company->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $applicationsByStatus = ContestApplication::whereHas('contest', fn ($q) => $q->where('company_id', $company->id))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topContests = Contest::where('company_id', $company->id)
            ->withCount(['interests', 'applications'])
            ->orderByDesc('views_count')
            ->limit(10)
            ->get();

        return view('company.statistics', compact(
            'company',
            'totalContests',
            'totalViews',
            'totalInterests',
            'totalApplications',
            'contestsByStatus',
            'applicationsByStatus',
            'topContests'
        ));
    }
}
