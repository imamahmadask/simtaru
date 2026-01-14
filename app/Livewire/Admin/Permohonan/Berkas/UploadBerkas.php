<?php

namespace App\Livewire\Admin\Permohonan\Berkas;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\PersyaratanBerkas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $permohonan;
    public $berkasId;
    public $layanan;

    #[Validate('required')]
    public $file;

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

    public function uploadBerkas()
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

    public function deleteBerkas($id)
    {
        $berkas = PermohonanBerkas::findOrFail($id);

        if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        $berkas->update([
            'file_path' => null,
            'uploaded_by' => null,
            'uploaded_at' => null,
            'status' => 'menunggu',
        ]);

        $this->setNextBerkas();
        session()->flash('message', 'Berkas berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.berkas.upload-berkas', [
            'berkas' => $this->berkasId ? PermohonanBerkas::find($this->berkasId) : null,
        ]);
    }
}
