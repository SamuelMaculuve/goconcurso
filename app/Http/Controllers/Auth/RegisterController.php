<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'professional_area' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'phone'             => $validated['phone'] ?? null,
            'professional_area' => $validated['professional_area'] ?? null,
            'role_type'         => 'candidate',
            'is_active'         => true,
        ]);

        $user->assignRole('candidate');
        Auth::login($user);

        return redirect()->route('profile.show')
            ->with('success', 'Conta criada com sucesso! Bem-vindo ao GoConcurso.');
    }

    public function showCompanyForm(): View
    {
        return view('auth.register-company');
    }

    public function registerCompany(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'max:255'],
            'country'      => ['required', 'string', 'max:100'],
            'city'         => ['required', 'string', 'max:100'],
            'sector'       => ['nullable', 'string', 'max:255'],
            'company_type' => ['required', 'in:public,private,ngo,international'],
            'company_role' => ['required', 'in:buyer,supplier,both'],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role_type' => 'company',
            'country'   => $validated['country'],
            'city'      => $validated['city'],
            'is_active' => true,
        ]);

        $user->assignRole('company');

        $freePlan = Plan::where('slug', 'gratuito')->first();

        Company::create([
            'user_id'      => $user->id,
            'name'         => $validated['company_name'],
            'slug'         => Str::slug($validated['company_name']) . '-' . Str::random(4),
            'email'        => $validated['email'],
            'country'      => $validated['country'],
            'city'         => $validated['city'],
            'sector'       => $validated['sector'] ?? null,
            'company_type' => $validated['company_type'],
            'company_role' => $validated['company_role'],
            'plan_id'      => $freePlan?->id,
            'is_active'    => true,
            'is_verified'  => false,
        ]);

        Auth::login($user);

        return redirect()->route('company.dashboard')
            ->with('success', 'Empresa registada com sucesso! Bem-vindo ao GoConcurso.');
    }
}
