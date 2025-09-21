<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Detail SKRK')]
class SkrkDetail extends Component
{
    public $skrk;
    public $count_verifikasi;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.skrk-detail');
    }

    public function mount($id)
    {
        $this->skrk = Skrk::findOrFail($id);
        $this->count_verifikasi = $this->skrk->permohonan->berkas->where('status', '!=', 'diterima')->count();
    }

    public function verifikasi($id, $status)
    {
        $berkas = PermohonanBerkas::find($id);

        $berkas->update([
            'status' => $status,
        ]);

        session()->flash('success', $status ? 'Verifikasi : Berkas diterima!' : 'Verifikasi : Berkas ditolak!');
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
