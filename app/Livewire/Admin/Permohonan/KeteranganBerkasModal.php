<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KeteranganBerkasModal extends Component
{
    public $permohonan_id;
    public $skrk_id;
    public $permohonan;

    public $instansi = 'DPMPTSP';
    public $proses = 'Input Permohonan';
    public $tanggal_status;
    public $catatan = '';

    public $riwayatLokasi = [];

    public function mount()
    {
        $this->tanggal_status = now()->format('Y-m-d');
    }

    public function updatedInstansi($value)
    {
        if ($value === 'DPMPTSP') {
            $this->proses = 'Input Permohonan';
        } elseif ($value === 'BPN') {
            $this->proses = 'Proses Survey';
        } else {
            $this->proses = null;
        }
    }

    #[On('open-modal-posisi-berkas')]
    public function openModal($permohonan_id = null, $skrk_id = null, $instansi = null, $proses = null, $kkprnb_id = null, $kkprb_id = null)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Akses ditolak. Fitur ini hanya dapat diakses oleh Superadmin.',
            ]);
            return;
        }

        // Support array payload from Livewire 3 event dispatch ($dispatch or named parameters)
        if (is_array($permohonan_id)) {
            $params = $permohonan_id;
            $permohonan_id = $params['permohonan_id'] ?? null;
            $skrk_id = $params['skrk_id'] ?? null;
            $kkprnb_id = $params['kkprnb_id'] ?? null;
            $kkprb_id = $params['kkprb_id'] ?? null;
            $instansi = $params['instansi'] ?? null;
            $proses = $params['proses'] ?? null;
        }

        $this->skrk_id = $skrk_id;

        if ($permohonan_id) {
            $this->permohonan_id = $permohonan_id;
        } elseif ($skrk_id) {
            $skrk = Skrk::find($skrk_id);
            $this->permohonan_id = $skrk?->permohonan_id;
        } elseif ($kkprnb_id) {
            $kkprnb = \App\Models\Kkprnb::find($kkprnb_id);
            $this->permohonan_id = $kkprnb?->permohonan_id;
        } elseif ($kkprb_id) {
            $kkprb = \App\Models\Kkprb::find($kkprb_id);
            $this->permohonan_id = $kkprb?->permohonan_id;
        }

        if (!$this->permohonan_id) {
            return;
        }

        $this->permohonan = Permohonan::with(['registrasi', 'layanan'])->findOrFail($this->permohonan_id);

        if ($this->permohonan->layanan && $this->permohonan->layanan->kode === 'ITR') {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Fitur posisi berkas tidak tersedia untuk layanan ITR.',
            ]);
            return;
        }

        if ($instansi) {
            $this->instansi = $instansi;
            if ($proses) {
                $this->proses = $proses;
            } elseif ($instansi === 'BPN') {
                $this->proses = 'Proses Survey';
            } elseif ($instansi === 'DPMPTSP') {
                $this->proses = 'Input Permohonan';
            } else {
                $this->proses = null;
            }
            $this->tanggal_status = now()->format('Y-m-d');
            $this->catatan = '';
        } elseif ($this->permohonan->posisi_berkas) {
            // Edit posisi berkas yang sudah ada
            $this->instansi = $this->permohonan->posisi_berkas;
            $this->proses = $this->permohonan->proses_berkas ?? ($this->instansi === 'BPN' ? 'Proses Survey' : 'Input Permohonan');
            $this->catatan = $this->permohonan->ket_posisi_berkas ?? '';
            $this->tanggal_status = $this->permohonan->tgl_posisi_berkas
                ? Carbon::parse($this->permohonan->tgl_posisi_berkas)->format('Y-m-d')
                : now()->format('Y-m-d');
        } else {
            $this->instansi = 'DPMPTSP';
            $this->proses = 'Input Permohonan';
            $this->tanggal_status = now()->format('Y-m-d');
            $this->catatan = '';
        }

        $this->loadRiwayatLokasi();

        $this->dispatch('show-posisi-berkas-modal');
    }

    public function loadRiwayatLokasi()
    {
        if (!$this->permohonan) {
            $this->riwayatLokasi = [];
            return;
        }

        $this->riwayatLokasi = RiwayatPermohonan::with('user')
            ->where('registrasi_id', $this->permohonan->registrasi_id)
            ->whereNotNull('instansi')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getProsesOptionsProperty()
    {
        if ($this->instansi === 'DPMPTSP') {
            return [
                'Input Permohonan' => 'Input Permohonan',
                'Cetak Berkas' => 'Cetak Berkas',
            ];
        } elseif ($this->instansi === 'BPN') {
            return [
                'Proses Survey' => 'Proses Survey',
                'Analisa' => 'Analisa',
            ];
        }

        return [];
    }

    public function getPreviewTextProperty()
    {
        if (!$this->instansi) {
            return '-';
        }

        $tgl = $this->tanggal_status ? Carbon::parse($this->tanggal_status)->translatedFormat('d F Y') : '-';
        $prosesLabel = $this->proses ? " ({$this->proses})" : '';
        $text = "Berkas berada di {$this->instansi}{$prosesLabel} per tanggal {$tgl}";

        if (!empty(trim($this->catatan))) {
            $text .= " - " . trim($this->catatan);
        }

        return $text;
    }

    public function saveKeterangan()
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Superadmin.');
        }

        $rules = [
            'instansi' => 'required|in:DPMPTSP,BPN',
            'tanggal_status' => 'required|date',
            'catatan' => 'nullable|string|max:1000',
        ];

        if ($this->instansi === 'DPMPTSP') {
            $rules['proses'] = 'required|in:Input Permohonan,Cetak Berkas';
        } elseif ($this->instansi === 'BPN') {
            $rules['proses'] = 'required|in:Proses Survey,Analisa';
        }

        $this->validate($rules);

        $tanggalFormatted = Carbon::parse($this->tanggal_status)->translatedFormat('d F Y');
        $prosesLabel = $this->proses ? " ({$this->proses})" : '';
        $keteranganText = "Berkas berada di {$this->instansi}{$prosesLabel} per tanggal {$tanggalFormatted}";

        if (!empty(trim($this->catatan))) {
            $keteranganText .= " - " . trim($this->catatan);
        }

        // Catat ke riwayat
        RiwayatPermohonan::create([
            'registrasi_id' => $this->permohonan->registrasi_id,
            'user_id' => Auth::id(),
            'instansi' => $this->instansi,
            'proses' => $this->proses,
            'tanggal_status' => $this->tanggal_status,
            'catatan' => $this->catatan,
            'keterangan' => $keteranganText,
        ]);

        // Update status terkini di tabel permohonan
        $this->permohonan->update([
            'posisi_berkas' => $this->instansi,
            'proses_berkas' => $this->proses,
            'tgl_posisi_berkas' => $this->tanggal_status,
            'ket_posisi_berkas' => $this->catatan,
        ]);

        $this->loadRiwayatLokasi();

        $this->dispatchRefreshes();

        $this->dispatch('trigger-close-posisi-berkas-modal');

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Keterangan posisi berkas berhasil disimpan dan dicatat pada riwayat!',
        ]);
    }

    public function clearPosisiBerkas()
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Superadmin.');
        }

        if (!$this->permohonan) {
            return;
        }

        // Catat di riwayat bahwa berkas telah kembali ke proses normal
        RiwayatPermohonan::create([
            'registrasi_id' => $this->permohonan->registrasi_id,
            'user_id' => Auth::id(),
            'instansi' => null,
            'proses' => null,
            'tanggal_status' => now()->format('Y-m-d'),
            'catatan' => 'Berkas kembali diproses di SIMTARU',
            'keterangan' => 'Berkas kembali diproses internal di SIMTARU per tanggal ' . now()->translatedFormat('d F Y'),
        ]);

        $this->permohonan->update([
            'posisi_berkas' => null,
            'proses_berkas' => null,
            'tgl_posisi_berkas' => null,
            'ket_posisi_berkas' => null,
        ]);

        $this->catatan = '';
        $this->loadRiwayatLokasi();

        $this->dispatchRefreshes();

        $this->dispatch('trigger-close-posisi-berkas-modal');

        $this->dispatch('toast', [
            'type' => 'info',
            'message' => 'Status posisi berkas telah dinonaktifkan (kembali ke SIMTARU).',
        ]);
    }

    public function deleteRiwayat($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            abort(403, 'Akses ditolak. Fitur ini hanya dapat diakses oleh Superadmin.');
        }

        $riwayat = RiwayatPermohonan::findOrFail($id);

        if (!$this->permohonan || $riwayat->registrasi_id != $this->permohonan->registrasi_id || !$riwayat->instansi) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Catatan riwayat tidak dapat dihapus.',
            ]);
            return;
        }

        $riwayat->delete();

        // Posisi terkini = catatan lokasi terakhir yang tersisa
        $latest = RiwayatPermohonan::where('registrasi_id', $this->permohonan->registrasi_id)
            ->whereNotNull('instansi')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        $this->permohonan->update([
            'posisi_berkas' => $latest?->instansi,
            'proses_berkas' => $latest?->proses,
            'tgl_posisi_berkas' => $latest?->tanggal_status,
            'ket_posisi_berkas' => $latest?->catatan,
        ]);
        $this->permohonan->refresh();

        // Samakan isian form dengan posisi terkini
        if ($latest) {
            $this->instansi = $latest->instansi;
            $this->proses = $latest->proses ?? ($latest->instansi === 'BPN' ? 'Proses Survey' : 'Input Permohonan');
            $this->tanggal_status = $latest->tanggal_status
                ? Carbon::parse($latest->tanggal_status)->format('Y-m-d')
                : now()->format('Y-m-d');
            $this->catatan = $latest->catatan ?? '';
        } else {
            $this->instansi = 'DPMPTSP';
            $this->proses = 'Input Permohonan';
            $this->tanggal_status = now()->format('Y-m-d');
            $this->catatan = '';
        }

        $this->loadRiwayatLokasi();
        $this->dispatchRefreshes();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Catatan riwayat posisi berhasil dihapus.',
        ]);
    }


    protected function dispatchRefreshes()
    {
        $this->dispatch('refresh-riwayat-permohonan');
        $this->dispatch('refresh-skrk-detail');
        $this->dispatch('refresh-skrk-index');
        $this->dispatch('refresh-skrk-survey-detail');
        $this->dispatch('refresh-skrk-analis-detail');
        $this->dispatch('refresh-kkprnb-detail');
        $this->dispatch('refresh-kkprnb-index');
        $this->dispatch('refresh-kkprnb-survey-detail');
        $this->dispatch('refresh-kkprnb-analis-detail');
        $this->dispatch('refresh-kkprb-detail');
        $this->dispatch('refresh-kkprb-index');
        $this->dispatch('refresh-kkprb-survey-detail');
        $this->dispatch('refresh-kkprb-analis-detail');
        $this->dispatch('refresh-permohonan-detail');
        $this->dispatch('refresh-permohonan-index');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.keterangan-berkas-modal');
    }
}
