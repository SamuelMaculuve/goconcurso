<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\SavedContest;

class SaveContest extends Component
{
    public int $contestId;
    public bool $saved = false;

    public function mount(int $contestId)
    {
        $this->contestId = $contestId;
        if (auth()->check()) {
            $this->saved = SavedContest::where('user_id', auth()->id())
                ->where('contest_id', $contestId)->exists();
        }
    }

    public function toggle()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existing = SavedContest::where('user_id', auth()->id())
            ->where('contest_id', $this->contestId)->first();

        if ($existing) {
            $existing->delete();
            $this->saved = false;
        } else {
            SavedContest::create(['user_id' => auth()->id(), 'contest_id' => $this->contestId]);
            $this->saved = true;
        }
    }

    public function render()
    {
        return view('livewire.save-contest');
    }
}
