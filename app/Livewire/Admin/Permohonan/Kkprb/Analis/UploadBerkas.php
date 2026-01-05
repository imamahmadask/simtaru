<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Analis;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $permohonan, $kkprb, $persyaratan_berkas, $tahapan_id;

    #[Validate(['file_.*' => 'mimes:.docx, .doc|max:10240'])]
    public $file_ = [];
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.analis.upload-berkas');
    }

    public function mount($permohonan_id, $kkprb_id)
    {
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->kkprb = Kkprb::findOrFail($kkprb_id);

        $this->tahapan_id = $this->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        $this->persyaratan_berkas = $this->permohonan->persyaratanBerkas->where('tahapan_id', $this->tahapan_id);
    }

    public function uploadBerkas()
    {
        $no_reg = $this->kkprb->registrasi->kode;

        foreach ($this->permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                // Check if a file already exists for this requirement
                $existingBerkas = PermohonanBerkas::where('permohonan_id', $this->permohonan->id)
                    ->where('persyaratan_berkas_id', $item->id)
                    ->where('versi', 'draft')
                    ->first();
                $isUpdate = $existingBerkas && $existingBerkas->file_path;

                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/kkprb
                $path = $uploadedFile->storeAs(
                    'kkprb/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                if($existingBerkas)
                {
                    if($existingBerkas->status == 'ditolak')
                    {
                        $existingBerkas->update([
                            'file_path'           => $path,
                            'uploaded_by'         => Auth::id(),
                            'uploaded_at'         => now(),
                        ]);
                    }
                }
                else
                {
                    PermohonanBerkas::updateOrCreate(
                        [
                            'permohonan_id'        => $this->permohonan->id,
                            'persyaratan_berkas_id'=> $item->id,
                            'versi'                => 'draft',
                        ],
                        [
                            'file_path'           => $path,
                            'uploaded_by'         => Auth::id(),
                            'uploaded_at'         => now(),
                            'status'              => 'menunggu',
                            'catatan_verifikator' => null,
                        ]
                    );
                }

               if ($isUpdate) {
                    session()->flash('success', 'Berkas Analisa berhasil diupdate!');
                } else {
                    session()->flash('success', 'Berkas Analisa berhasil ditambahkan!');
                }
            }
        }

        // Check if all required analysis files are uploaded and update the flag
        $requiredBerkas = $this->persyaratan_berkas->where('wajib', 1);
        $requiredCount = $requiredBerkas->count();
        $uploadedCount = PermohonanBerkas::where('permohonan_id', $this->permohonan->id)
            ->whereIn('persyaratan_berkas_id', $requiredBerkas->pluck('id'))
            ->count();

        if ($requiredCount > 0 && $requiredCount === $uploadedCount) {
            $this->kkprb->update(['is_berkas_analis_uploaded' => true]);
        } else {
            $this->kkprb->update(['is_berkas_analis_uploaded' => false]);
        }

        $this->reset('file_');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas Analisa berhasil ditambahkan!'
        ]);

        $this->dispatch('refresh-kkprb-analis-list');

        $this->dispatch('trigger-close-modal');
    }    
}
