<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $permohonan, $kkprnb, $persyaratan_berkas, $tahapan_id;

    #[Validate(['file_.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'])]
    public $file_ = [];

    public $catatan_ = [];

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.upload-berkas');
    }

    public function mount($permohonan_id, $kkprnb_id)
    {
        $this->permohonan = Permohonan::with(['layanan.tahapan', 'persyaratanBerkas', 'berkas'])->findOrFail($permohonan_id);
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);

        $this->tahapan_id = $this->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        $this->persyaratan_berkas = $this->permohonan->persyaratanBerkas->where('tahapan_id', $this->tahapan_id);

        $existingBerkasMap = $this->permohonan->berkas->where('versi', 'draft')->keyBy('persyaratan_berkas_id');

        foreach ($this->persyaratan_berkas as $item) {
            $berkas = $existingBerkasMap->get($item->id);

            if ($berkas && $berkas->catatan) {
                $this->catatan_[$item->kode] = $berkas->catatan;
            }
        }
    }

    public function uploadBerkas()
    {
        $this->validate();

        $no_reg = $this->kkprnb->registrasi->kode;
        $isUpdate = false;
        $hasNewUpload = false;

        $existingBerkasMap = PermohonanBerkas::where('permohonan_id', $this->permohonan->id)
            ->where('versi', 'draft')
            ->get()
            ->keyBy('persyaratan_berkas_id');

        foreach ($this->permohonan->persyaratanBerkas as $item) {
            // Check if a file already exists for this requirement
            $existingBerkas = $existingBerkasMap->get($item->id);

            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $hasNewUpload = true;
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

                if($existingBerkas)
                {
                    if($existingBerkas->status == 'ditolak')
                    {
                        $existingBerkas->update([
                            'file_path'           => $path,
                            'catatan'             => $this->catatan_[$item->kode] ?? null,
                            'status'              => 'menunggu',
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
            }
            else
            {
                if($existingBerkas)
                {                    
                    if($existingBerkas->status == 'ditolak')
                    {                       
                        $existingBerkas->update([
                            'catatan'             => $this->catatan_[$item->kode] ?? null,
                            'status'              => 'ditolak',
                        ]);
                    }
                }
            }
        }

        if ($hasNewUpload) {
            $this->updateBerkasStatus();
        }

        $this->reset('file_', 'catatan_');

        if ($isUpdate) {
            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Berkas Analisa berhasil diupdate!'
            ]);
        } else {
            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Berkas Analisa berhasil ditambahkan!'
            ]);
        }

        $this->dispatch('refresh-kkprnb-analis-list');
        $this->dispatch('refresh-kkprnb-verifikasi-list');

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

        // Update is_berkas_analis_uploaded flag
        $this->updateBerkasStatus();

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas berhasil dihapus!'
        ]);

        $this->dispatch('refresh-kkprnb-analis-list');
        $this->dispatch('refresh-kkprnb-verifikasi-list');
    }

    private function updateBerkasStatus()
    {
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
    }
}
