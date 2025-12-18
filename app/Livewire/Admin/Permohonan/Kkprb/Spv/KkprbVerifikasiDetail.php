<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Spv;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprbVerifikasiDetail extends Component
{
    public $kkprb;
    public $count_verifikasi;
    public $berkas_draft;

    #[On('refresh-kkprb-verifikasi-list')]
    public function refresh()
    {
        $this->mount($this->kkprb->id);
    }

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.spv.kkprb-verifikasi-detail');
    }

    public function mount($kkprb_id)
    {
        $this->kkprb = Kkprb::findOrFail($kkprb_id);
        $this->count_verifikasi = $this->kkprb->permohonan->berkas->where('status', '!=', 'diterima')->where('versi', 'draft')->count();
        $this->berkas_draft = $this->kkprb->permohonan->berkas->where('versi', 'draft');
    }

    public function selesaiVerifikasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {

            if($this->count_verifikasi == 0) {
                $this->kkprb->update([
                    'is_validate' => true
                ]);

                $this->kkprb->permohonan->update([
                    'status' => 'Cetak Dokumen'
                ]);

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanAnalisId = $this->kkprb->permohonan->layanan->tahapan->where('nama', 'Verifikasi')->value('id');
                if ($tahapanAnalisId) {
                    $this->kkprb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->kkprb->permohonan, 'Selesai Analisa Data KKPR Non Berusaha');
                }

                $tahapan = Tahapan::where('layanan_id', $this->kkprb->permohonan->layanan_id)->where('urutan', 4)->first();

                $this->kkprb->disposisis()->create([
                    'permohonan_id' => $this->kkprb->permohonan->id,
                    'tahapan_id' => $tahapan->id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $this->kkprb->permohonan->created_by,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Lanjutkan proses cetak Dokumen KKPR Non Berusaha',
                ]);

                $this->createRiwayat($this->kkprb->permohonan, 'Selesai Verifikasi Berkas KKPR Non Berusaha');
                $this->createRiwayat($this->kkprb->permohonan, 'Sedang Proses Cetak Dokumen KKPR Non Berusaha');

                session()->flash('success', 'Data Verifikasi selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Verifikasi belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('kkprb.detail', ['id' => $this->kkprb->id]);
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
