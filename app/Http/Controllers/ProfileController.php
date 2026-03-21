<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function show(): View
    {
        $user = Auth::user();

        $recentApplications = $user->applications()
            ->with('contest.company')
            ->latest()
            ->limit(5)
            ->get();

        $applicationsCount = $user->applications()->count();
        $savedCount        = $user->savedContests()->count();
        $interestsCount    = $user->interests()->count();

        return view('profile.show', compact(
            'user',
            'recentApplications',
            'applicationsCount',
            'savedCount',
            'interestsCount'
        ));
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'bio'               => ['nullable', 'string', 'max:1000'],
            'country'           => ['nullable', 'string', 'max:100'],
            'city'              => ['nullable', 'string', 'max:100'],
            'professional_area' => ['nullable', 'string', 'max:255'],
            'avatar'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cv'                => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $data = collect($validated)->except(['avatar', 'cv'])->toArray();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso.');
    }

    public function applications(): View
    {
        $applications = Auth::user()->applications()
            ->with('contest.company')
            ->latest()
            ->paginate(10);

        return view('profile.applications', compact('applications'));
    }

    public function saved(): View
    {
        $savedContests = Auth::user()->savedContests()
            ->with('contest.company', 'contest.category')
            ->latest()
            ->paginate(12);

        return view('profile.saved', compact('savedContests'));
    }

    public function interests(): View
    {
        $interests = Auth::user()->interests()
            ->with('contest.company')
            ->latest()
            ->paginate(10);

        return view('profile.interests', compact('interests'));
    }
}
