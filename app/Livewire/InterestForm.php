<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contest;
use App\Models\ContestInterest;

class InterestForm extends Component
{
    use WithFileUploads;

    public Contest $contest;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $professional_area = '';
    public string $message = '';
    public $cv = null;
    public bool $submitted = false;

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->phone ?? '';
            $this->professional_area = auth()->user()->professional_area ?? '';
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'professional_area' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function submit()
    {
        $this->validate();

        $cvPath = null;
        if ($this->cv) {
            $cvPath = $this->cv->store('cvs', 'public');
        }

        ContestInterest::create([
            'contest_id' => $this->contest->id,
            'user_id' => auth()->id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'professional_area' => $this->professional_area,
            'message' => $this->message,
            'cv_path' => $cvPath,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.interest-form');
    }
}
