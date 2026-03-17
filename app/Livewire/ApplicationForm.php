<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ApplicationDocument;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public Contest $contest;
    public string $solution_description = '';
    public string $proposed_value = '';
    public string $currency = 'USD';
    public $technical_doc = null;
    public array $documents = [];
    public bool $submitted = false;

    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->currency = $contest->budget_currency ?? 'USD';
    }

    protected function rules()
    {
        return [
            'solution_description' => 'required|string|min:50|max:5000',
            'proposed_value'       => 'nullable|numeric|min:0',
            'currency'             => 'required|string|max:10',
            'technical_doc'        => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'documents.*'          => 'nullable|file|max:10240',
        ];
    }

    public function submit()
    {
        $this->validate();

        $docPath = null;
        if ($this->technical_doc) {
            $docPath = $this->technical_doc->store('applications/cvs', 'public');
        }

        $application = ContestApplication::create([
            'contest_id'           => $this->contest->id,
            'user_id'              => auth()->id(),
            'solution_description' => $this->solution_description,
            'proposed_value'       => $this->proposed_value ?: null,
            'currency'             => $this->currency,
            'cv_path'              => $docPath,
            'status'               => 'pending',
        ]);

        foreach ($this->documents as $doc) {
            $path = $doc->store('applications/docs', 'public');
            ApplicationDocument::create([
                'application_id' => $application->id,
                'name'           => $doc->getClientOriginalName(),
                'file_path'      => $path,
                'file_type'      => $doc->getMimeType(),
            ]);
        }

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.application-form');
    }
}
