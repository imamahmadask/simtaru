<?php

namespace App\Livewire\Admin\Permohonan\Itr\Spv;

use App\Models\Itr;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ItrVerifikasiDetail extends Component
{
    public $itr;
    public $count_verifikasi;
    public $berkas_draft;

    #[On('refresh-itr-verifikasi-list')]
    public function refresh()
    {
        $this->itr->refresh();
        $this->mount($this->itr->id);
    }
    
    public function render()
    {
        return view('livewire.admin.permohonan.itr.spv.itr-verifikasi-detail');
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::findOrFail($itr_id);
        $this->count_verifikasi = $this->itr->permohonan->berkas->where('status', '!=', 'diterima')->where('versi', 'draft')->count();
        $this->berkas_draft = $this->itr->permohonan->berkas->where('versi', 'draft');

    }

    public function selesaiVerifikasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {

            if($this->count_verifikasi == 0) {
                $this->itr->update([
                    'is_validate' => true
                ]);

                $this->itr->permohonan->update([
                    'status' => 'Cetak Dokumen'
                ]);

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanVerifikasiId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Verifikasi')->value('id');
                if ($tahapanVerifikasiId) {
                    $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanVerifikasiId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->itr->permohonan, 'Selesai Verifikasi Data ITR', Auth::user()->id);
                }

                $tahapan = Tahapan::where('layanan_id', $this->itr->permohonan->layanan_id)->where('urutan', 4)->first();

                $this->itr->disposisis()->create([
                    'permohonan_id' => $this->itr->permohonan->id,
                    'tahapan_id' => $tahapan->id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $this->itr->permohonan->created_by,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Lanjutkan proses cetak Dokumen ITR',
                ]);

                $this->createRiwayat($this->itr->permohonan, 'Sedang Proses Cetak Dokumen ITR', $this->itr->permohonan->created_by);

                session()->flash('success', 'Data Verifikasi selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Verifikasi belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan, int $user_id)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => $user_id,
            'keterangan' => $keterangan
        ]);
    }
}
