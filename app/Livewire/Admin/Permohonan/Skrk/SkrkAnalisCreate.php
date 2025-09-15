<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class SkrkAnalisCreate extends Component
{
    use WithFileUploads;

    public $permohonan_id, $skrk_id;

    public $penguasaan_tanah, $ada_bangunan, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;

    public $file_ = [];

    public function render()
    {
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $tahapan_id = $permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        $persyaratan_berkas = $permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_id);

        return view('livewire.admin.permohonan.skrk.skrk-analis-create', [
            'persyaratan_berkas' => $persyaratan_berkas
        ]);
    }

    public function createAnalisa()
    {
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $skrk = Skrk::findOrFail($this->skrk_id);
        $no_reg = $skrk->registrasi->kode;

        foreach ($permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/skrk_form_survey
                $path = $uploadedFile->storeAs(
                    'skrk_form_survey/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->permohonan_id,
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

        $skrk->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'ada_bangunan' => $this->ada_bangunan,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max
        ]);

        $this->createRiwayat($permohonan, 'Entry Data Analisa');

        session()->flash('success', 'Data Analisa berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;
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
