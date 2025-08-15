<?php

namespace App\Livewire\Admin\Permohonan\Berkas;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $permohonan;
    public $berkasId;
    public $file;

    protected $rules = [
        'file' => 'required|file|max:2048', // max 2MB
    ];

    public function mount(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
        $this->setNextBerkas();
    }

    public function setNextBerkas()
    {
        $next = $this->permohonan->berkas()
            ->whereNull('file_path')
            ->orderBy('persyaratan_berkas_id', 'asc')
            ->first();

        $this->berkasId = $next ? $next->id : null;
    }

    public function upload()
    {
        $this->validate();

        $berkas = PermohonanBerkas::findOrFail($this->berkasId);

        $path = $this->file->store('permohonan/' . $this->permohonan->id, 'public');

        $berkas->update([
            'file_path' => $path,
            'uploaded_by' => Auth::user()->id,
            'uploaded_at' => now(),
            'status' => 'menunggu',
        ]);

        $this->reset('file');
        $this->setNextBerkas();
        session()->flash('message', 'Berkas berhasil diupload!');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.berkas.upload-berkas', [
            'berkas' => $this->berkasId ? PermohonanBerkas::find($this->berkasId) : null,
        ]);
    }
}
