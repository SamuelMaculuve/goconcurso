<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin']);
    }

    public function index(): View
    {
        $totalUsers = User::count();
        $totalCompanies = Company::count();
        $totalContests = Contest::count();
        $totalApplications = ContestApplication::count();

        $monthlyContests = Contest::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(fn ($row) => [
                'label' => sprintf('%04d-%02d', $row->year, $row->month),
                'total' => $row->total,
            ]);

        $monthlyUsers = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(fn ($row) => [
                'label' => sprintf('%04d-%02d', $row->year, $row->month),
                'total' => $row->total,
            ]);

        $monthlyContestsJson = $monthlyContests->toJson();
        $monthlyUsersJson = $monthlyUsers->toJson();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCompanies',
            'totalContests',
            'totalApplications',
            'monthlyContestsJson',
            'monthlyUsersJson'
        ));
    }
}
