<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Analis;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprbAnalisDetail extends Component
{
    public $kkprb;
    public $koordinatTable = false;

    #[On('refresh-kkprb-analis-list')]
    public function refresh() {}

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.analis.kkprb-analis-detail');
    }

    public function mount($kkprb_id)
    {
        $this->kkprb = Kkprb::find($kkprb_id);
    }

    public function download2a()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'nib' => $this->kkprb->nib,
            'oss_id' => $this->kkprb->oss_id,
            'proyek_id' => $this->kkprb->proyek_id,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('2A_BA_RAPAT_FPR.docx', $data);
    }

    public function download2b()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('2B_NOTULENSI_RAPAT_FPR.docx', $data);
    }

    public function download3()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'tgl_oss' =>  $this->kkprb->tgl_oss ? date('d F Y', strtotime($this->kkprb->tgl_oss)) : '-',
            'tgl_validasi' => $this->kkprb->tgl_validasi ? date('d F Y', strtotime($this->kkprb->tgl_validasi)) : '-',
            'tgl_pnbp' => $this->kkprb->pnbp ? date('d F Y', strtotime($this->kkprb->pnbp)) : '-',
            'tgl_ptp' => $this->kkprb->tgl_ptp ? date('d F Y', strtotime($this->kkprb->tgl_ptp)) : '-',
            'no_ptp' => $this->kkprb->no_ptp,
            'tgl_survey' => $this->kkprb->tgl_survey ? date('d F Y', strtotime($this->kkprb->tgl_survey)) : '-',
            'proyek_id' => $this->kkprb->id_proyek,
            'skala_usaha' => $this->kkprb->skala_usaha,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'kbli' => $permohonan->kbli,
            'judul_kbli' => $permohonan->judul_kbli,
            'status_modal' => $permohonan->status_modal,
            'luas_tanah' => $permohonan->luas_tanah,
            'luas_bangunan' => $permohonan->luas_bangunan,
            'jml_lantai' => $permohonan->jml_lantai,
            'penguasaan_tanah' => $this->kkprb->penguasaan_tanah,
            'jenis_usaha' => $this->kkprb->jenis_usaha,
            'ada_bangunan' => $this->kkprb->ada_bangunan,
            'jml_bangunan' => $this->kkprb->jml_bangunan,
            'jml_lantai' => $this->kkprb->jml_lantai,
            'luas_lantai' => $this->kkprb->luas_lantai,
            'kedalaman_min' => $this->kkprb->kedalaman_min,
            'kedalaman_max' => $this->kkprb->kedalaman_max,
            'ketinggian_min' => $this->kkprb->ketinggian_min,
            'ketinggian_max' => $this->kkprb->ketinggian_max,
            'kdb' => $this->kkprb->kdb,
            'klb' => $this->kkprb->klb,
            'kdh' => $this->kkprb->kdh,
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('3_KAJIAN_KKPRB.docx', $data);
    }

    public function download4()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'kbli' => $permohonan->kbli,
            'judul_kbli' => $permohonan->judul_kbli,
            'tgl_oss' => $this->kkprb->tgl_oss ? date('d F Y', strtotime($this->kkprb->tgl_oss)) : '-',
            'tgl_validasi' => $this->kkprb->tgl_validasi ? date('d F Y', strtotime($this->kkprb->tgl_validasi)) : '-',
            'tgl_pnbp' => $this->kkprb->pnbp ? date('d F Y', strtotime($this->kkprb->pnbp)) : '-',
            'tgl_ptp' => $this->kkprb->tgl_ptp ? date('d F Y', strtotime($this->kkprb->tgl_ptp)) : '-',
            'no_ptp' => $this->kkprb->no_ptp,
            'proyek_id' => $this->kkprb->proyek_id,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'status_modal' => $permohonan->status_modal,
            'penguasaan_tanah' => $this->kkprb->penguasaan_tanah,
            'jenis_usaha' => $this->kkprb->jenis_usaha,
            'ada_bangunan' => $this->kkprb->ada_bangunan,
            'jml_bangunan' => $this->kkprb->jml_bangunan,
            'jml_lantai' => $this->kkprb->jml_lantai,
            'luas_lantai' => $this->kkprb->luas_lantai,
            'luas_disetujui' => $this->kkprb->luas_disetujui,
            'tgl_survey' => $this->kkprb->tgl_survey ? date('d F Y', strtotime($this->kkprb->tgl_survey)) : '-',
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('4_NOTA_DINAS_KAJIAN_KKPRB.docx', $data);
    }

    public function download5()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'no_ptp' => $this->kkprb->no_ptp,
            'tgl_ptp' => $this->kkprb->tgl_ptp ? date('d F Y', strtotime($this->kkprb->tgl_ptp)) : '-',            
        ];
        $this->koordinatTable = false;
        return $this->generateDocument('5_REKOMENDASI_KKPRB.docx', $data);
    }

    public function download6()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'jenis_kegiatan' => $this->kkprb->jenis_kegiatan,
            'no_ptp' => $this->kkprb->no_ptp,
            'tgl_ptp' => $this->kkprb->tgl_ptp ? date('d F Y', strtotime($this->kkprb->tgl_ptp)) : '-',
            'kdb' => $this->kkprb->kdb,
            'klb' => $this->kkprb->klb,
            'kdh' => $this->kkprb->kdh,
            'gsb' => $this->kkprb->gsb,
        ];
        $this->koordinatTable = true;
        return $this->generateDocument('6_FORMAT_PERSETUJUAN_KKPRB.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/kkprb/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        if($this->koordinatTable)
        {
            $koordinatList = $this->kkprb->koordinat;
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

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function selesaiAnalisa()
    {
        if(Auth::user()->role == 'analis' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor') {
            $this->kkprb->update([
                'is_analis' => true
            ]);

            $this->kkprb->permohonan->update([
                'status' => 'Proses Verifikasi'
            ]);

            // Find and update the disposisi for the 'Analisis' stage
            $tahapanAnalisId = $this->kkprb->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
            if ($tahapanAnalisId) {
                $this->kkprb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->update([
                    'is_done' => true,
                    'tgl_selesai' => now()
                ]);
                $this->createRiwayat($this->kkprb->permohonan, 'Selesai Analisa Data KKPR Berusaha', Auth::user()->id);
            }

            // Create disposisi to supervisor for 'Verifikasi' tahapan
            $tahapanVerifikasi = Tahapan::where('layanan_id', $this->kkprb->permohonan->layanan_id)
                                        ->where('nama', 'Verifikasi')
                                        ->first();
            $supervisor = User::where('role', 'supervisor')->first();
            $pemberi_id = $this->kkprb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)->value('penerima_id') ?? Auth::user()->id;
            if ($tahapanVerifikasi && $supervisor) {
                $this->kkprb->disposisis()->create([
                    'permohonan_id' => $this->kkprb->permohonan->id,
                    'tahapan_id' => $tahapanVerifikasi->id,
                    'pemberi_id' => $pemberi_id,
                    'penerima_id' => $supervisor->id,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Mohon untuk melakukan verifikasi data hasil analisa.',
                ]);
                
                $this->createRiwayat($this->kkprb->permohonan, 'Proses Verifikasi Data KKPR Berusaha', $supervisor->id);
            }


            session()->flash('success', 'Data Analis selesai!');
        }


        return redirect()->route('kkprb.detail', ['id' => $this->kkprb->id]);
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
