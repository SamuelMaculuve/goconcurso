<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContestCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = ContestCategory::withCount('contests')->orderBy('name')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:contest_categories,name'],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:50'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        ContestCategory::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'color'       => $validated['color'] ?? null,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(int $id): View
    {
        $category = ContestCategory::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $category = ContestCategory::findOrFail($id);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:contest_categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:50'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'color'       => $validated['color'] ?? null,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = ContestCategory::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
