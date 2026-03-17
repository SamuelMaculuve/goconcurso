<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ContestInterest;
use App\Models\ContestView;
use App\Models\SavedContest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContestController extends Controller
{
    public function index(): View
    {
        // Handled by Livewire ContestSearch component
        return view('contests.index');
    }

    public function show(string $slug): View
    {
        $contest = Contest::where('slug', $slug)
            ->where('status', 'active')
            ->with(['company', 'category', 'documents'])
            ->firstOrFail();

        // Record view
        ContestView::create([
            'contest_id' => $contest->id,
            'user_id'    => Auth::id(),
            'ip_address' => request()->ip(),
            'viewed_at'  => now(),
        ]);
        $contest->increment('views_count');

        $isSaved = false;
        $hasApplied = false;
        $hasInterest = false;

        if (Auth::check()) {
            $isSaved = SavedContest::where('user_id', Auth::id())
                ->where('contest_id', $contest->id)->exists();
            $hasApplied = ContestApplication::where('user_id', Auth::id())
                ->where('contest_id', $contest->id)->exists();
            $hasInterest = ContestInterest::where('user_id', Auth::id())
                ->where('contest_id', $contest->id)->exists();
        }

        $related = Contest::where('status', 'active')
            ->where('category_id', $contest->category_id)
            ->where('id', '!=', $contest->id)
            ->with('company')
            ->limit(3)
            ->get();

        return view('contests.show', compact('contest', 'isSaved', 'hasApplied', 'hasInterest', 'related'));
    }

    public function save(string $slug): RedirectResponse
    {
        $contest = Contest::where('slug', $slug)->firstOrFail();
        $existing = SavedContest::where('user_id', Auth::id())
            ->where('contest_id', $contest->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Concurso removido dos guardados.';
        } else {
            SavedContest::create(['user_id' => Auth::id(), 'contest_id' => $contest->id]);
            $message = 'Concurso guardado com sucesso.';
        }

        return back()->with('success', $message);
    }

    public function interestForm(string $slug): View
    {
        $contest = Contest::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('contests.interest', compact('contest'));
    }

    public function storeInterest(Request $request, string $slug): RedirectResponse
    {
        $contest = Contest::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'phone'             => ['required', 'string', 'max:50'],
            'professional_area' => ['required', 'string', 'max:255'],
            'message'           => ['nullable', 'string', 'max:1000'],
            'cv'                => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('interests/cv', 'public');
        }

        ContestInterest::create([
            'contest_id'        => $contest->id,
            'user_id'           => Auth::id(),
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'],
            'professional_area' => $validated['professional_area'],
            'message'           => $validated['message'] ?? null,
            'cv_path'           => $cvPath,
            'status'            => 'new',
        ]);

        return redirect()->route('contests.show', $contest->slug)
            ->with('success', 'O seu interesse foi registado com sucesso! A empresa irá contactá-lo.');
    }

    public function applyForm(string $slug): View
    {
        $contest = Contest::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('contests.apply', compact('contest'));
    }

    public function apply(Request $request, string $slug): RedirectResponse
    {
        $contest = Contest::where('slug', $slug)->where('status', 'active')->firstOrFail();

        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:3000'],
            'cv'           => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'documents'    => ['nullable', 'array'],
            'documents.*'  => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
        ]);

        $cvPath = $request->file('cv')->store('applications/cv', 'public');

        $application = ContestApplication::create([
            'contest_id'   => $contest->id,
            'user_id'      => Auth::id(),
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path'      => $cvPath,
            'status'       => 'pending',
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $docPath = $doc->store('applications/docs', 'public');
                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'name'           => $doc->getClientOriginalName(),
                    'file_path'      => $docPath,
                    'file_type'      => $doc->getMimeType(),
                ]);
            }
        }

        return redirect()->route('contests.show', $contest->slug)
            ->with('success', 'Candidatura submetida com sucesso! Boa sorte.');
    }
}
