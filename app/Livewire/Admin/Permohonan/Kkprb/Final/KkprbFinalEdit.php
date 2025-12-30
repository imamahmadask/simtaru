<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Final;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class KkprbFinalEdit extends Component
{

     use WithFileUploads;

    public $kkprb;
    public $permohonan;
    public $persyaratan_berkas;
    public $file_ = [];
    public $tgl_selesai, $no_dokumen, $waktu_pengerjaan;
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.final.kkprb-final-edit');
    }

    public function mount($permohonan_id, $kkprb_id)
    {
        $this->kkprb = Kkprb::find($kkprb_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->persyaratan_berkas = $this->kkprb->permohonan->persyaratanBerkas;

        $this->tgl_selesai = $this->permohonan->tgl_selesai;
        $this->no_dokumen = $this->permohonan->no_dokumen;
        $this->waktu_pengerjaan = $this->permohonan->waktu_pengerjaan;
    }

    public function editFinal()
    {
        $no_reg = $this->kkprb->registrasi->kode;

        foreach ($this->persyaratan_berkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/kkprb_form_survey
                $path = $uploadedFile->storeAs(
                    'kkprb/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->kkprb->permohonan->id,
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

        $this->kkprb->permohonan->update([
            'tgl_selesai' => $this->tgl_selesai,
            'no_dokumen' => $this->no_dokumen,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
        ]);
        
        $this->reset('tgl_selesai', 'no_dokumen', 'waktu_pengerjaan', 'file_');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Dokumen KKPR Berusaha Fix berhasil diupdate!'
        ]);
        
        $this->dispatch('refresh-kkprb-final-list');

        $this->dispatch('trigger-close-modal');
    }

    public function updated($tgl_selesai)
    {
        $tgl_mulai = Carbon::parse($this->permohonan->registrasi->tanggal);
        $tgl_selesai = Carbon::parse($this->tgl_selesai);
        $this->waktu_pengerjaan = $tgl_mulai->diffInDays($tgl_selesai) + 1;
    }
}
