<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Contest;
use App\Models\ContestCategory;
use Livewire\WithPagination;

class ContestSearch extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = '';
    public string $contest_type = '';
    public string $country = '';
    public string $city = '';
    public string $professional_area = '';
    public string $sort = 'latest';

    protected $queryString = ['search', 'category', 'contest_type', 'country', 'city', 'sort'];

    public function updatedSearch() { $this->resetPage(); }
    public function updatedCategory() { $this->resetPage(); }
    public function updatedContestType() { $this->resetPage(); }

    public function render()
    {
        $query = Contest::with(['company', 'category'])
            ->where('status', 'active')
            ->when($this->search, fn($q) => $q->where(function($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%')
                  ->orWhere('professional_area', 'like', '%'.$this->search.'%');
            }))
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->when($this->contest_type, fn($q) => $q->where('contest_type', $this->contest_type))
            ->when($this->country, fn($q) => $q->where('country', 'like', '%'.$this->country.'%'))
            ->when($this->city, fn($q) => $q->where('city', 'like', '%'.$this->city.'%'))
            ->when($this->professional_area, fn($q) => $q->where('professional_area', 'like', '%'.$this->professional_area.'%'));

        if ($this->sort === 'deadline') {
            $query->orderBy('deadline', 'asc');
        } elseif ($this->sort === 'popular') {
            $query->orderBy('views_count', 'desc');
        } else {
            $query->latest();
        }

        $contests = $query->paginate(12);
        $categories = ContestCategory::where('is_active', true)->get();

        return view('livewire.contest-search', compact('contests', 'categories'));
    }
}
