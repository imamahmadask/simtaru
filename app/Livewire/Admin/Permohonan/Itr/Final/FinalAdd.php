<?php

namespace App\Livewire\Admin\Permohonan\Itr\Final;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class FinalAdd extends Component
{
    use WithFileUploads;

    public $itr;
    public $permohonan;
    public $persyaratan_berkas;
    public $tgl_selesai, $no_dokumen, $waktu_pengerjaan;

    #[Validate('mimes:pdf|max:10240')]
    public $file_ = [];

    public function render()
    {
        return view('livewire.admin.permohonan.itr.final.final-add');
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->itr = Itr::find($itr_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->persyaratan_berkas = $this->itr->permohonan->persyaratanBerkas;
    }

    public function addFinal()
    {
        $no_reg = $this->itr->registrasi->kode;

        foreach ($this->persyaratan_berkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/itr_form_survey
                $path = $uploadedFile->storeAs(
                    'itr/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->itr->permohonan->id,
                        'persyaratan_berkas_id'=> $item->id,
                        'versi'                => 'final',
                    ],
                    [
                        'file_path'           => $path,
                        'uploaded_by'         => Auth::id(),
                        'uploaded_at'         => now(),
                        'status'              => 'diterima',
                        'catatan_verifikator' => null,
                    ]
                );
            }
        }

        $this->itr->permohonan->update([
            'tgl_selesai' => $this->tgl_selesai,
            'no_dokumen' => $this->no_dokumen,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,            
        ]);             
        
        $this->reset('tgl_selesai', 'no_dokumen', 'waktu_pengerjaan', 'file_');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Dokumen ITR berhasil ditambahkan!'
        ]);
        
        $this->dispatch('refresh-itr-final-list');

        $this->dispatch('trigger-close-modal');
    }

    public function updated($tgl_selesai)
    {
        $tgl_mulai = Carbon::parse($this->permohonan->registrasi->tanggal);
        $tgl_selesai = Carbon::parse($this->tgl_selesai);
        $this->waktu_pengerjaan = $tgl_mulai->diffInDays($tgl_selesai) + 1;
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
