<?php

namespace App\Livewire\Admin\Template;

use App\Models\DocumentTemplate;
use App\Services\DocumentTemplateService;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Manajemen Dokumen Template')]
class TemplateIndex extends Component
{
    use WithFileUploads;

    public string $selectedModul = 'all';
    public string $search = '';
    public string $statusFilter = 'all';

    public ?int $selectedTemplateId = null;
    public $file_template;

    public array $inspectionResult = [];

    protected $rules = [
        'file_template' => 'required|file|mimes:docx|max:10240',
    ];

    protected $messages = [
        'file_template.required' => 'Silakan pilih file template .docx terlebih dahulu.',
        'file_template.mimes' => 'Format file harus berupa dokumen Word (.docx).',
        'file_template.max' => 'Ukuran file tidak boleh melebihi 10 MB.',
    ];

    public function updatedFileTemplate()
    {
        $this->validateOnly('file_template');

        if ($this->file_template) {
            $service = app(DocumentTemplateService::class);
            $this->inspectionResult = $service->inspectFile($this->file_template);
        } else {
            $this->inspectionResult = [];
        }
    }

    public function openEditModal(int $id)
    {
        $this->resetValidation();
        $this->file_template = null;
        $this->inspectionResult = [];
        $this->selectedTemplateId = $id;

        $this->dispatch('open-template-modal');
    }

    public function closeEditModal()
    {
        $this->selectedTemplateId = null;
        $this->file_template = null;
        $this->inspectionResult = [];
        $this->dispatch('close-template-modal');
    }

    public function uploadTemplate()
    {
        $this->validate();

        $template = DocumentTemplate::findOrFail($this->selectedTemplateId);
        $service = app(DocumentTemplateService::class);

        try {
            $service->saveCustomTemplate($template, $this->file_template, auth()->id());
            session()->flash('success', "Template '{$template->nama}' berhasil diperbarui!");
            $this->closeEditModal();
        } catch (\Throwable $e) {
            $this->addError('file_template', $e->getMessage());
        }
    }

    public function resetToDefault(int $id)
    {
        $template = DocumentTemplate::findOrFail($id);
        $template->resetToDefault();

        session()->flash('success', "Template '{$template->nama}' berhasil dikembalikan ke versi default bawaan!");
        
        if ($this->selectedTemplateId === $id) {
            $this->closeEditModal();
        }
    }

    public function downloadTemplate(int $id)
    {
        $template = DocumentTemplate::findOrFail($id);
        $service = app(DocumentTemplateService::class);

        return $service->downloadActiveTemplate($template);
    }

    public function render()
    {
        $query = DocumentTemplate::with('updatedBy')->orderBy('modul')->orderBy('nama');

        if ($this->selectedModul !== 'all') {
            $query->where('modul', $this->selectedModul);
        }

        if ($this->statusFilter === 'custom') {
            $query->whereNotNull('custom_path');
        } elseif ($this->statusFilter === 'default') {
            $query->whereNull('custom_path');
        }

        if (!empty(trim($this->search))) {
            $searchTerm = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', $searchTerm)
                  ->orWhere('kode', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        $templates = $query->get();

        // Modul list dengan count
        $modules = [
            'all' => 'Semua Modul (' . DocumentTemplate::count() . ')',
            'skrk' => 'SKRK (' . DocumentTemplate::where('modul', 'skrk')->count() . ')',
            'itr' => 'ITR (' . DocumentTemplate::where('modul', 'itr')->count() . ')',
            'kkprb' => 'KKPR Berusaha (' . DocumentTemplate::where('modul', 'kkprb')->count() . ')',
            'kkprnb' => 'KKPR Non-Berusaha (' . DocumentTemplate::where('modul', 'kkprnb')->count() . ')',
            'pelanggaran' => 'Pelanggaran (' . DocumentTemplate::where('modul', 'pelanggaran')->count() . ')',
            'registrasi' => 'Registrasi (' . DocumentTemplate::where('modul', 'registrasi')->count() . ')',
        ];

        $selectedTemplate = $this->selectedTemplateId 
            ? DocumentTemplate::with('updatedBy')->find($this->selectedTemplateId) 
            : null;

        return view('livewire.admin.template.template-index', [
            'templates' => $templates,
            'modules' => $modules,
            'selectedTemplate' => $selectedTemplate,
        ]);
    }
}
