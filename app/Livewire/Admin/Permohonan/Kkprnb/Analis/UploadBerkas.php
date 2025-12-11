<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $permohonan, $kkprnb, $persyaratan_berkas, $tahapan_id;

    #[Validate(['file_.*' => 'mimes:.docx, .doc|max:2000'])]
    public $file_ = [];

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.upload-berkas');
    }

    public function mount($permohonan_id, $kkprnb_id)
    {
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);

        $this->tahapan_id = $this->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        $this->persyaratan_berkas = $this->permohonan->persyaratanBerkas->where('tahapan_id', $this->tahapan_id);
    }

    public function uploadBerkas()
    {
        $no_reg = $this->kkprnb->registrasi->kode;

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

                // simpan file ke storage/app/public/kkprnb
                $path = $uploadedFile->storeAs(
                    'kkprnb/' . $no_reg, // folder per registrasi
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
                    $this->createRiwayat($this->permohonan, 'Upload Berkas Analisa');
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
            $this->kkprnb->update(['is_berkas_analis_uploaded' => true]);
        } else {
            $this->kkprnb->update(['is_berkas_analis_uploaded' => false]);
        }

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas Analisa berhasil ditambahkan!'
        ]);
        
        $this->dispatch('refresh-kkprnb-analis-list');

        $this->dispatch('trigger-close-modal');
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }

}
