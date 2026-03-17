<?php

namespace App\Livewire;

use Livewire\Component;

class ContestSearchHero extends Component
{
    public string $search = '';

    public function submit(): mixed
    {
        return redirect()->route('contests.index', array_filter(['search' => $this->search]));
    }

    public function render()
    {
        return view('livewire.contest-search-hero');
    }
}
