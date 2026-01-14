<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Spv;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprnbVerifikasiDetail extends Component
{
    public $kkprnb;
    public $count_verifikasi;
    public $berkas_draft;
    public $kesimpulan;

    #[On('refresh-kkprnb-verifikasi-list')]
    public function refresh()
    {
        $this->kkprnb->refresh();
        $this->kkprnb->load(['permohonan.berkas']);
        $this->loadData();
    }
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.spv.kkprnb-verifikasi-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);
        $this->loadData();
    }

    public function loadData()
    {
        $this->count_verifikasi = $this->kkprnb->permohonan->berkas->where('status', '!=', 'diterima')->where('versi', 'draft')->count();
        $this->berkas_draft = $this->kkprnb->permohonan->berkas->where('versi', 'draft');
        $this->kesimpulan = $this->kkprnb->kesimpulan ?? '';
    }

    public function submitKesimpulan()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {
            
            if($this->kesimpulan != '') {
                $this->kkprnb->update([
                    'kesimpulan' => $this->kesimpulan
                ]);
            }
        }

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Kesimpulan berhasil disimpan'
        ]);
        
        $this->dispatch('refresh-kkprnb-verifikasi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function selesaiVerifikasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {

            if($this->count_verifikasi == 0) {
                $this->kkprnb->update([
                    'is_validate' => true,
                    'tgl_validate' => now()
                ]);

                $this->kkprnb->permohonan->update([
                    'status' => 'Cetak Dokumen'
                ]);

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanSpvId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Verifikasi')->value('id');
                if ($tahapanSpvId) {
                    $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanSpvId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->kkprnb->permohonan, 'Selesai Verifikasi Data KKPR Non Berusaha', Auth::user()->id);
                }

                $tahapan = Tahapan::where('layanan_id', $this->kkprnb->permohonan->layanan_id)->where('urutan', 4)->first();

                $this->kkprnb->disposisis()->create([
                    'permohonan_id' => $this->kkprnb->permohonan->id,
                    'tahapan_id' => $tahapan->id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $this->kkprnb->permohonan->created_by,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Lanjutkan proses cetak Dokumen KKPR Non Berusaha',
                ]);
                
                $data_entry = User::where('role', 'data-entry')->first()->id;
                $this->createRiwayat($this->kkprnb->permohonan, 'Proses Cetak Dokumen Data KKPR Non Berusaha', $data_entry);

                session()->flash('success', 'Data Verifikasi selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Verifikasi belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('kkprnb.detail', ['id' => $this->kkprnb->id]);
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan, $user_id)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => $user_id,
            'keterangan' => $keterangan
        ]);
    }
}
