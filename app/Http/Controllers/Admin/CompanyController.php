<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Company::with(['user', 'plan']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nif', 'like', "%{$search}%");
            });
        }

        $companies = $query->latest()->paginate(20)->withQueryString();

        return view('admin.companies.index', compact('companies'));
    }

    public function show(int $id): View
    {
        $company = Company::with(['user', 'plan', 'contests'])->findOrFail($id);

        return view('admin.companies.show', compact('company'));
    }

    public function verify(int $id): RedirectResponse
    {
        $company = Company::findOrFail($id);

        $company->update(['is_verified' => true]);

        return back()->with('success', 'Company verified successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $company = Company::findOrFail($id);

        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}
