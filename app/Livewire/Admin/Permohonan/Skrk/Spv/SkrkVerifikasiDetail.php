<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkrkVerifikasiDetail extends Component
{
    public $skrk;
    public $count_verifikasi;
    public $berkas_draft;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.spv.skrk-verifikasi-detail');
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::findOrFail($skrk_id);
        $this->count_verifikasi = $this->skrk->permohonan->berkas->where('status', '!=', 'diterima')->where('versi', 'draft')->count();
        $this->berkas_draft = $this->skrk->permohonan->berkas->where('versi', 'draft');

    }

    public function selesaiVerifikasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {

            if($this->count_verifikasi == 0) {
                $this->skrk->update([
                    'is_validate' => true
                ]);

                $this->skrk->permohonan->update([
                    'status' => 'Cetak Dokumen'
                ]);

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanAnalisId = $this->skrk->permohonan->layanan->tahapan->where('nama', 'Verifikasi')->value('id');
                if ($tahapanAnalisId) {
                    $this->skrk->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->skrk->permohonan, 'Selesai Analisa Data SKRK');
                }

                $tahapan = Tahapan::where('layanan_id', $this->skrk->permohonan->layanan_id)->where('urutan', 4)->first();

                $this->skrk->disposisis()->create([
                    'permohonan_id' => $this->skrk->permohonan->id,
                    'tahapan_id' => $tahapan->id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $this->skrk->permohonan->created_by,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Lanjutkan proses cetak Dokumen SKRK',
                ]);

                $this->createRiwayat($this->skrk->permohonan, 'Selesai Verifikasi Berkas SKRK');
                $this->createRiwayat($this->skrk->permohonan, 'Sedang Proses Cetak Dokumen SKRK');

                session()->flash('success', 'Data Verifikasi selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Verifikasi belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
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
