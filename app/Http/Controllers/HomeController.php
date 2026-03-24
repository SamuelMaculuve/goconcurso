<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredContests = Contest::where('status', 'active')
            ->where('is_featured', true)
            ->with(['company', 'category'])
            ->latest()
            ->limit(9)
            ->get();

        $latestContests = Contest::where('status', 'active')
            ->with(['company', 'category'])
            ->latest()
            ->limit(6)
            ->get();

        $contests = $featuredContests->isEmpty() ? $latestContests : $featuredContests;

        $categories = ContestCategory::where('is_active', true)
            ->withCount(['contests' => fn($q) => $q->where('status', 'active')])
            ->orderByDesc('contests_count')
            ->limit(12)
            ->get();

        $ads = Advertisement::where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('position', 'homepage_banner')
            ->get();

        $stats = [
            'active_contests' => Contest::where('status', 'active')->count(),
            'companies'       => Company::where('is_active', true)->count(),
            'candidates'      => User::role('candidate')->count(),
        ];

        return view('home', compact('contests', 'featuredContests', 'categories', 'ads', 'stats'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        // Log or mail the message — swap Mail::raw for a proper Mailable when ready
        Mail::raw(
            "De: {$validated['name']} <{$validated['email']}>\n\n{$validated['message']}",
            function ($msg) use ($validated) {
                $msg->to(config('mail.from.address', 'info@GoConcurso.ao'))
                    ->subject("Contacto: {$validated['subject']}");
            }
        );

        return redirect()->route('contact')->with('success', 'Mensagem enviada com sucesso! Responderemos em breve.');
    }

    public function help(): View
    {
        return view('pages.help');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function pricing(): View
    {
        $plans = \App\Models\Plan::where('is_active', true)->orderBy('price')->get();
        return view('pages.pricing', compact('plans'));
    }

    public function companies(): View
    {
        $companies = Company::where('is_active', true)
            ->where('is_verified', true)
            ->withCount(['contests' => fn($q) => $q->where('status', 'active')])
            ->latest()
            ->paginate(16);

        return view('pages.companies', compact('companies'));
    }

    public function showCompany(string $slug): View
    {
        $company = Company::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $activeContests = $company->contests()
            ->where('status', 'active')
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('companies.show', compact('company', 'activeContests'));
    }
}
