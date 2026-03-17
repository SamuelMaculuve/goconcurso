<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin']);
    }

    public function index(): View
    {
        $plans = Plan::withCount('companies')->orderBy('price')->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.plans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'string', 'in:monthly,quarterly,annual'],
            'max_contests'  => ['required', 'integer', 'min:1'],
            'features'      => ['nullable', 'array'],
            'features.*'    => ['string', 'max:255'],
            'is_active'     => ['nullable', 'boolean'],
            'is_featured'   => ['nullable', 'boolean'],
        ]);

        Plan::create([
            'name'          => $validated['name'],
            'slug'          => Str::slug($validated['name']),
            'description'   => $validated['description'] ?? null,
            'price'         => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'max_contests'  => $validated['max_contests'],
            'features'      => $validated['features'] ?? [],
            'is_active'     => $request->boolean('is_active'),
            'is_featured'   => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(int $id): View
    {
        $plan = Plan::findOrFail($id);

        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'string', 'in:monthly,quarterly,annual'],
            'max_contests'  => ['required', 'integer', 'min:1'],
            'features'      => ['nullable', 'array'],
            'features.*'    => ['string', 'max:255'],
            'is_active'     => ['nullable', 'boolean'],
            'is_featured'   => ['nullable', 'boolean'],
        ]);

        $plan->update([
            'name'          => $validated['name'],
            'slug'          => Str::slug($validated['name']),
            'description'   => $validated['description'] ?? null,
            'price'         => $validated['price'],
            'billing_cycle' => $validated['billing_cycle'],
            'max_contests'  => $validated['max_contests'],
            'features'      => $validated['features'] ?? [],
            'is_active'     => $request->boolean('is_active'),
            'is_featured'   => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $plan = Plan::findOrFail($id);

        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }
}
