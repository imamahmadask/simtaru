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
    public $disposisiAnalis = null;

    #[On('refresh-kkprnb-analis-detail')]
    public function refresh() {
        $this->kkprnb->refresh();
    }

    public function render()
    {
        // Get the current analis disposisi for showing start button
        $tahapanAnalisId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        if ($tahapanAnalisId) {
            $this->disposisiAnalis = $this->kkprnb->permohonan->disposisi()
                ->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->latest()
                ->first();
        }

        return view('livewire.admin.permohonan.kkprnb.analis.kkprnb-analis-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
    }

    public function mulaiKerja()
    {
        $tahapanAnalisId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
        if ($tahapanAnalisId) {
            $disposisi = $this->kkprnb->permohonan->disposisi()
                ->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->whereNull('tgl_mulai_kerja')
                ->latest()
                ->first();

            if ($disposisi) {
                $disposisi->update([
                    'tgl_mulai_kerja' => now(),
                ]);
                session()->flash('success', 'Waktu mulai kerja telah dicatat!');
            }
        }
    }

    public function download3b()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'jenis_kegiatan' => htmlspecialchars($permohonan->registrasi->fungsi_bangunan, ENT_QUOTES, 'UTF-8'),
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah
        ];
        $this->koordinatTable = false;

        return $this->generateDocument('3B_BA_RAPAT_FPR_NON_BERUSAHA.docx', $data);
    }

    public function download3c()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
        ];
        $this->koordinatTable = false;
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
        $batas = $this->kkprnb->batas_persil;
        $analis = $permohonan->disposisi->where('tahapan_id', $permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id'))->first()->penerima->name ?? '-';
        
        $data = [
            'analis' => $analis,
            'nama_pemohon' => $permohonan->registrasi->nama,
            'nik' => $permohonan->registrasi->nik,
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
            'jenis_kegiatan' => htmlspecialchars($permohonan->registrasi->fungsi_bangunan, ENT_QUOTES, 'UTF-8'),
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
            'gsb' => $this->kkprnb->gsb,
            'status_jalan' => $this->kkprnb->status_jalan,
            'tipe_jalan' => $this->kkprnb->tipe_jalan,
            'fungsi_jalan' => $this->kkprnb->fungsi_jalan,
            'median_jalan' => $this->kkprnb->median_jalan,
            'lebar_jalan' => $this->kkprnb->lebar_jalan,
            'batas_barat' => $batas ? $batas['barat'] : '______',
            'batas_timur' => $batas ? $batas['timur'] : '______',
            'batas_utara' => $batas ? $batas['utara'] : '______',
            'batas_selatan' => $batas ? $batas['selatan'] : '______',
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('3D_KAJIAN_KKPR_NONBERUSAHA.docx', $data);
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
            'jenis_kegiatan' => htmlspecialchars($permohonan->registrasi->fungsi_bangunan, ENT_QUOTES, 'UTF-8'),
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
        $this->koordinatTable = false;
        return $this->generateDocument('4_NOTA_DINAS_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download5()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'no_ptp' => $this->kkprnb->no_ptp,
            'tgl_ptp' => $this->kkprnb->tgl_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_ptp)) : '-',
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('5_REKOMENDASI_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download6()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'nik' => $permohonan->registrasi->nik,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => htmlspecialchars($permohonan->registrasi->fungsi_bangunan, ENT_QUOTES, 'UTF-8'),
            'jenis_kegiatan_pemanfaatan' => $this->kkprnb->jenis_kegiatan,
            'luas_permohonan' => $permohonan->luas_tanah,
            'no_ptp' => $this->kkprnb->no_ptp,
            'tgl_ptp' => $this->kkprnb->tgl_ptp ? date('d F Y', strtotime($this->kkprnb->tgl_ptp)) : '-',
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max,
            'kdb' => $this->kkprnb->kdb,
            'klb' => $this->kkprnb->klb,
            'indikasi_program' => $this->kkprnb->indikasi_program,
            'persyaratan_pelaksanaan' => htmlspecialchars($this->kkprnb->persyaratan_pelaksanaan, ENT_QUOTES, 'UTF-8'),
            'gsb' => $this->kkprnb->gsb,
            'jbb' => $this->kkprnb->jbb,
            'kdh' => $this->kkprnb->kdh,
            'ktb' => $this->kkprnb->ktb,
            'ketinggian_bangunan_max' => $this->kkprnb->ketinggian_bangunan_max,
            'jaringan_utilitas' => $this->kkprnb->jaringan_utilitas,
            'luas_disetujui' => $this->kkprnb->luas_disetujui,
        ];

        $this->koordinatTable = true;
        return $this->generateDocument('6_FORMAT_PERSETUJUAN_KKPR_NONBERUSAHA.docx', $data);
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

        // Sanitize filename by removing special characters
        $baseName = str_replace('.docx', '', basename($templatePath));
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nama_pemohon']);
        $fileName = $baseName . '_' . $sanitizedName . '.docx';
        $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $fileName);

        $templateProcessor->saveAs($tempPath);

        if (ob_get_contents()) ob_end_clean();

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
                $this->createRiwayat($this->kkprnb->permohonan, 'Selesai Analisa Data KKPR Non Berusaha', Auth::user()->id);
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
                
                $this->createRiwayat($this->kkprnb->permohonan, 'Proses Verifikasi Data KKPR Non Berusaha', $supervisor->id);
            }


            session()->flash('success', 'Data Analis selesai!');
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
