<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprnbAnalisDetail extends Component
{
    public $kkprnb;
    public $koordinatTable = false;

    #[On('refresh-kkprnb-analis-list')]
    public function refresh() {}

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.kkprnb-analis-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
    }

    public function download3b()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah
        ];

        return $this->generateDocument('3B_BA_RAPAT_FPR_NON_BERUSAHA.docx', $data);
    }

    public function download3c()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
        ];

        return $this->generateDocument('3C_NOTULENSI_RAPAT_FPR_NON_BERUSAHA.docx', $data);
    }

    public function download3d()
    {
        $permohonan = $this->kkprnb->permohonan;
        $textKoordinat = '';
        if($this->kkprnb->koordinat){
            foreach ($this->kkprnb->koordinat as $i => $point) {
                $textKoordinat .= "{$point['x']}, {$point['y']}\n";
            }
        }

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'tgl_registrasi' => $permohonan->registrasi->tanggal ? date('d F Y', strtotime($permohonan->registrasi->tanggal)) : '-',
            'tgl_validasi' => $this->kkprnb->tgl_validasi ? date('d F Y', strtotime($this->kkprnb->tgl_validasi)) : '-',
            'tgl_survey' => $this->kkprnb->tgl_survey ? date('d F Y', strtotime($this->kkprnb->tgl_survey)) : '-',
            'tgl_ptp' => $this->kkprnb->tgl_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_ptp)) : '-',
            'tgl_terima_ptp' => $this->kkprnb->tgl_terima_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_terima_ptp)) : '-',
            'no_ptp' => $this->kkprnb->no_ptp ?? '-',
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'penguasaan_tanah' => $this->kkprnb->penguasaan_tanah,
            'ada_bangunan' => $this->kkprnb->ada_bangunan,
            'jml_bangunan' => $this->kkprnb->jml_bangunan,
            'jml_lantai' => $this->kkprnb->jml_lantai,
            'luas_lantai' => $this->kkprnb->luas_lantai,
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max,
            'koordinat' => $textKoordinat,
            'kdb' => $this->kkprnb->kdb,
            'klb' => $this->kkprnb->klb,
            'kdh' => $this->kkprnb->kdh,
        ];

        return $this->generateDocument('3D_KAJIAN_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download4()
    {
        $permohonan = $this->kkprnb->permohonan;
        $textKoordinat = '';
        if($this->kkprnb->koordinat){
            foreach ($this->kkprnb->koordinat as $i => $point) {
                $textKoordinat .= "{$point['x']}, {$point['y']}\n";
            }
        }
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'tgl_registrasi' => $permohonan->registrasi->tanggal ? date('d F Y', strtotime($permohonan->registrasi->tanggal)) : '-',
            'no_registrasi' => $permohonan->registrasi->kode,
            'tgl_validasi' => $this->kkprnb->tgl_validasi ? date('d F Y', strtotime($this->kkprnb->tgl_validasi)) : '-',
            'tgl_survey' => $this->kkprnb->tgl_survey ? date('d F Y', strtotime($this->kkprnb->tgl_survey)) : '-',
            'tgl_ptp' => $this->kkprnb->tgl_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_ptp)) : '-',
            'tgl_terima_ptp' => $this->kkprnb->tgl_terima_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_terima_ptp)) : '-',
            'no_ptp' => $this->kkprnb->no_ptp ?? '-',
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'penguasaan_tanah' => $this->kkprnb->penguasaan_tanah,
            'ada_bangunan' => $this->kkprnb->ada_bangunan,
            'jml_bangunan' => $this->kkprnb->jml_bangunan,
            'jml_lantai' => $this->kkprnb->jml_lantai,
            'luas_lantai' => $this->kkprnb->luas_lantai,
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max,
            'koordinat' => $textKoordinat,
        ];

        return $this->generateDocument('4_NOTA_DINAS_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download5()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'no_ptp' => $this->kkprnb->no_ptp,
            'tgl_ptp' => $this->kkprnb->tgl_ptp,
        ];

        return $this->generateDocument('5_REKOMENDASI_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download6()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'jenis_kegiatan_pemanfaatan' => $this->kkprnb->jenis_kegiatan,
            'luas_permohonan' => $permohonan->luas_tanah,
            'no_ptp' => $this->kkprnb->no_ptp,
            'tgl_ptp' => $this->kkprnb->tgl_ptp,
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max,
            'kdb' => $this->kkprnb->kdb,
            'klb' => $this->kkprnb->klb,
            'indikasi_program' => $this->kkprnb->indikasi_program,
            'persyaratan_pelaksanaan' => $this->kkprnb->persyaratan_pelaksanaan,
            'gsb' => $this->kkprnb->gsb,
            'jbb' => $this->kkprnb->jbb,
            'kdh' => $this->kkprnb->kdh,
            'ktb' => $this->kkprnb->ktb,
            'jaringan_utilitas' => $this->kkprnb->jaringan_utilitas,
        ];

        $this->koordinatTable = true;        
        return $this->generateDocument('6_FORMAT_PERSETUJUAN_KKPR_NON_BERUSAHA.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/kkprnb/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        if($this->koordinatTable)
        {
            $koordinatList = $this->kkprnb->koordinat;
            // 🧭 Jika ada data koordinat, isi ke tabel di Word
            if (!empty($koordinatList)) {
                // Clone baris berdasarkan placeholder 'x'
                $templateProcessor->cloneRow('x', count($koordinatList));

                foreach ($koordinatList as $i => $point) {
                    $row = $i + 1;
                    $templateProcessor->setValue("x#{$row}", $point['x']);
                    $templateProcessor->setValue("y#{$row}", $point['y']);
                }
            }
            else
            {
                // Jika tidak ada koordinat, tampilkan satu baris kosong
                $templateProcessor->cloneRow('x', 1);
                $templateProcessor->setValue('x#1', '-');
                $templateProcessor->setValue('y#1', '-');
            }
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function selesaiAnalisa()
    {
        if(Auth::user()->role == 'analis' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor') {
            $this->kkprnb->update([
                'is_analis' => true
            ]);

            $this->kkprnb->permohonan->update([
                'status' => 'Proses Verifikasi'
            ]);

            // Find and update the disposisi for the 'Analisis' stage
            $tahapanAnalisId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
            if ($tahapanAnalisId) {
                $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->update([
                    'is_done' => true,
                    'tgl_selesai' => now()
                ]);
                $this->createRiwayat($this->kkprnb->permohonan, 'Selesai Analisa Data KKPR Non Berusaha');
            }

            // Create disposisi to supervisor for 'Verifikasi' tahapan
            $tahapanVerifikasi = Tahapan::where('layanan_id', $this->kkprnb->permohonan->layanan_id)
                                        ->where('nama', 'Verifikasi')
                                        ->first();
            $supervisor = User::where('role', 'supervisor')->first();
            $pemberi_id = $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)->value('penerima_id') ?? Auth::user()->id;
            if ($tahapanVerifikasi && $supervisor) {
                $this->kkprnb->disposisis()->create([
                    'permohonan_id' => $this->kkprnb->permohonan->id,
                    'tahapan_id' => $tahapanVerifikasi->id,
                    'pemberi_id' => $pemberi_id,
                    'penerima_id' => $supervisor->id,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Mohon untuk melakukan verifikasi data hasil analisa.',
                ]);
            }

            $this->createRiwayat($this->kkprnb->permohonan, 'Proses Verifikasi Data KKPR NB');

            session()->flash('success', 'Data Analis selesai!');
        }


        return redirect()->route('kkprnb.detail', ['id' => $this->kkprnb->id]);
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
