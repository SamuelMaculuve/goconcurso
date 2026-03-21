<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContestController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contest::with(['company', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $contests = $query->latest()->paginate(20)->withQueryString();

        $statuses = ['pending', 'active', 'cancelled', 'closed'];

        return view('admin.contests.index', compact('contests', 'statuses'));
    }

    public function approve(int $id): RedirectResponse
    {
        $contest = Contest::findOrFail($id);

        $contest->update(['status' => 'active']);

        return back()->with('success', 'Contest approved and set to active.');
    }

    public function reject(int $id): RedirectResponse
    {
        $contest = Contest::findOrFail($id);

        $contest->update(['status' => 'cancelled']);

        return back()->with('success', 'Contest has been rejected.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $contest = Contest::findOrFail($id);

        $contest->delete();

        return redirect()->route('admin.contests.index')
            ->with('success', 'Contest deleted successfully.');
    }
}
