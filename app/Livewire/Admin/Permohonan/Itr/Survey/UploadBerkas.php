<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $persyaratan_berkas, $permohonan, $itr;

    #[Validate(['file_.*' => 'required|mimes:.docx, .doc|max:2000'])]
    public $file_ = [];

    public $catatan_ = [];

    public function render()
    {
        return view('livewire.admin.permohonan.itr.survey.upload-berkas');
    }

    public function  uploadBerkas()
    {
        $no_reg = $this->itr->registrasi->kode;
        $isUpdate = false;
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

                // simpan file ke storage/app/public/itr
                $path = $uploadedFile->storeAs(
                    'itr/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                if($existingBerkas)
                {
                    if($existingBerkas->status == 'ditolak')
                    {
                        $existingBerkas->update([
                            'file_path'           => $path,
                            'catatan'             => $this->catatan_[$item->kode] ?? null,
                            'uploaded_by'         => Auth::id(),
                            'uploaded_at'         => now(),
                        ]);
                    }
                }
                else
                {
                    // simpan ke database
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
                            'catatan'             => $this->catatan_[$item->kode] ?? null,
                        ]
                    );
                }


                if ($isUpdate) {
                    session()->flash('success', 'Berkas Survey berhasil diupdate!');
                } else {
                    session()->flash('success', 'Berkas Survey berhasil ditambahkan!');
                }
            }
        }

        $this->updateBerkasStatus();

        if ($isUpdate) {
            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Berkas Survey berhasil diupdate!'
            ]);
        } else {
            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Berkas Survey berhasil ditambahkan!'
            ]);
        }

        $this->dispatch('refresh-itr-survey-list');
        $this->dispatch('refresh-itr-verifikasi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function deleteBerkas($berkas_id)
    {
        $berkas = PermohonanBerkas::findOrFail($berkas_id);

        // Delete file from storage
        if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        // Delete from database
        $berkas->delete();

        // Update is_berkas_survey_uploaded flag
        $this->updateBerkasStatus();

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas berhasil dihapus!'
        ]);

        $this->dispatch('refresh-itr-survey-list');
        $this->dispatch('refresh-itr-verifikasi-list');
    }

    private function updateBerkasStatus()
    {
        $requiredBerkas = $this->persyaratan_berkas->where('wajib', 1);
        $requiredCount = $requiredBerkas->count();
        $uploadedCount = PermohonanBerkas::where('permohonan_id', $this->permohonan->id)
            ->whereIn('persyaratan_berkas_id', $requiredBerkas->pluck('id'))
            ->count();

        if ($requiredCount > 0 && $requiredCount === $uploadedCount) {
            $this->itr->update(['is_berkas_survey_uploaded' => true]);
        } else {
            $this->itr->update(['is_berkas_survey_uploaded' => false]);
        }
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->itr = Itr::findOrFail($itr_id);

        $tahapan_id = $this->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        $this->persyaratan_berkas = $this->permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_id);
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
