<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ContestCategory;
use App\Models\ContestDocument;
use App\Models\ContestInterest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContestController extends Controller
{
    public function allInterests(): View
    {
        $company = $this->getCompany();

        $interests = ContestInterest::whereHas('contest', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['user', 'contest'])->latest()->paginate(20);

        return view('company.contests.interests', compact('interests'));
    }

    public function allApplications(): View
    {
        $company = $this->getCompany();

        $applications = ContestApplication::whereHas('contest', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['user', 'contest'])->latest()->paginate(20);

        return view('company.contests.applications', compact('applications'));
    }

    private function getCompany()
    {
        return Auth::user()->company ?? abort(403, 'Perfil de empresa não encontrado.');
    }

    public function index(): View
    {
        $company = $this->getCompany();

        $contests = Contest::where('company_id', $company->id)
            ->with('category')
            ->withCount(['interests', 'applications'])
            ->latest()
            ->paginate(15);

        return view('company.contests.index', compact('contests'));
    }

    public function create(): View
    {
        $categories = ContestCategory::where('is_active', true)->orderBy('name')->get();
        return view('company.contests.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $company = $this->getCompany();

        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'description'        => ['required', 'string'],
            'category_id'        => ['required', 'exists:contest_categories,id'],
            'contest_type'       => ['required', 'string', 'in:public_contest,tender,project_call,consulting'],
            'participation_type' => ['required', 'string', 'in:info_only,interest_submission,full_application'],
            'accepts_proposals'  => ['nullable', 'boolean'],
            'location_type'      => ['nullable', 'string', 'in:local,national,international,remote'],
            'country'            => ['nullable', 'string', 'max:100'],
            'city'               => ['nullable', 'string', 'max:100'],
            'professional_area'  => ['nullable', 'string', 'max:255'],
            'requirements'       => ['nullable', 'string'],
            'benefits'           => ['nullable', 'string'],
            'budget_min'         => ['nullable', 'numeric', 'min:0'],
            'budget_max'         => ['nullable', 'numeric', 'min:0'],
            'budget_currency'    => ['nullable', 'string', 'max:10'],
            'deadline'           => ['required', 'date', 'after:today'],
            'external_url'       => ['nullable', 'url', 'max:500'],
            'documents'          => ['nullable', 'array'],
            'documents.*'        => ['file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $validated['accepts_proposals'] = $request->boolean('accepts_proposals');
        $slug = Str::slug($validated['title']) . '-' . Str::random(6);

        $contest = Contest::create(array_merge($validated, [
            'company_id' => $company->id,
            'slug'       => $slug,
            'status'     => 'active',
        ]));

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                ContestDocument::create([
                    'contest_id' => $contest->id,
                    'name'       => $doc->getClientOriginalName(),
                    'file_path'  => $doc->store('contests/documents', 'public'),
                    'file_type'  => $doc->getMimeType(),
                    'file_size'  => $doc->getSize(),
                ]);
            }
        }

        return redirect()->route('company.contests.index')
            ->with('success', 'Concurso publicado com sucesso! Já está disponível na plataforma.');
    }

    public function edit(int $id): View
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->with('documents')->findOrFail($id);
        $categories = ContestCategory::where('is_active', true)->orderBy('name')->get();
        return view('company.contests.edit', compact('contest', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->findOrFail($id);

        $validated = $request->validate([
            'title'              => ['required', 'string', 'max:255'],
            'description'        => ['required', 'string'],
            'category_id'        => ['required', 'exists:contest_categories,id'],
            'contest_type'       => ['required', 'string', 'in:public_contest,tender,project_call,consulting'],
            'participation_type' => ['required', 'string', 'in:info_only,interest_submission,full_application'],
            'accepts_proposals'  => ['nullable', 'boolean'],
            'location_type'      => ['nullable', 'string', 'in:local,national,international,remote'],
            'country'            => ['nullable', 'string', 'max:100'],
            'city'               => ['nullable', 'string', 'max:100'],
            'professional_area'  => ['nullable', 'string', 'max:255'],
            'requirements'       => ['nullable', 'string'],
            'benefits'           => ['nullable', 'string'],
            'budget_min'         => ['nullable', 'numeric', 'min:0'],
            'budget_max'         => ['nullable', 'numeric', 'min:0'],
            'budget_currency'    => ['nullable', 'string', 'max:10'],
            'deadline'           => ['required', 'date'],
            'external_url'       => ['nullable', 'url', 'max:500'],
        ]);

        $validated['accepts_proposals'] = $request->boolean('accepts_proposals');
        $contest->update($validated);

        return redirect()->route('company.contests.index')
            ->with('success', 'Concurso atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->findOrFail($id);
        $contest->delete();

        return redirect()->route('company.contests.index')
            ->with('success', 'Concurso eliminado com sucesso.');
    }

    public function interests(int $id): View
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->findOrFail($id);
        $interests = ContestInterest::where('contest_id', $contest->id)
            ->latest()->paginate(20);

        return view('company.contests.interests', compact('contest', 'interests'));
    }

    public function applications(int $id): View
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->findOrFail($id);
        $applications = ContestApplication::where('contest_id', $contest->id)
            ->with(['user', 'documents'])->latest()->paginate(20);

        return view('company.contests.applications', compact('contest', 'applications'));
    }

    public function updateApplicationStatus(Request $request, int $contestId, int $appId): RedirectResponse
    {
        $company = $this->getCompany();
        $contest = Contest::where('company_id', $company->id)->findOrFail($contestId);
        $application = ContestApplication::where('contest_id', $contest->id)->findOrFail($appId);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewing,accepted,rejected'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ]);

        $application->update($validated);

        return back()->with('success', 'Estado da proposta actualizado.');
    }
}
