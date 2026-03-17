<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ContestInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:company']);
    }

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
}
