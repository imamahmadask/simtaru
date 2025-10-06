<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadBerkas extends Component
{
    use WithFileUploads;

    public $persyaratan_berkas, $permohonan, $skrk;

    public $file_ = [];
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.upload-berkas');
    }

    public function  uploadBerkas()
    {
        $no_reg = $this->skrk->registrasi->kode;

        foreach ($this->permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/skrk
                $path = $uploadedFile->storeAs(
                    'skrk/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->permohonan->id,
                        'persyaratan_berkas_id'=> $item->id,
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
        }

        // Check if all required survey files are uploaded and update the flag
        $requiredCount = $this->persyaratan_berkas->count();
        $requiredBerkas = $this->persyaratan_berkas->where('wajib', 1);
        $requiredCount = $requiredBerkas->count();
        $uploadedCount = PermohonanBerkas::where('permohonan_id', $this->permohonan->id)
            ->whereIn('persyaratan_berkas_id', $this->persyaratan_berkas->pluck('id'))
            ->whereIn('persyaratan_berkas_id', $requiredBerkas->pluck('id'))
            ->count();

        if ($requiredCount > 0 && $requiredCount === $uploadedCount) {
            $this->skrk->update(['is_berkas_survey_uploaded' => true]);
        } else {
            $this->skrk->update(['is_berkas_survey_uploaded' => false]);
        }

        $this->createRiwayat($this->permohonan, 'Upload Berkas Survey');

        session()->flash('success', 'Berkas Survey berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->skrk = Skrk::findOrFail($skrk_id);

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
