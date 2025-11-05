<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Analis;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class SkrkAnalisDetail extends Component
{
    public $skrk;
    public $koodinatTable = false;
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.analis.skrk-analis-detail');
    }
    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
    }

    public function download2a()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'jenis_bangunan' => $permohonan->jenis_bangunan,
        ];

        return $this->generateDocument('2A_BA_rapat_fpr.docx', $data);
    }

    public function download2b()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
        ];

        return $this->generateDocument('2B_notulensi_rapat_fpr.docx', $data);
    }

    public function download3()
    {
        $permohonan = $this->skrk->permohonan;
        $textKoordinat = '';
        if($this->skrk->koordinat){
            foreach ($this->skrk->koordinat as $i => $point) {
                $textKoordinat .= "{$point['x']}, {$point['y']}\n";
            }
        }

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'tanggal_regis' => date('d F Y', strtotime($permohonan->registrasi->tanggal)),
            'kode_regis' => $permohonan->registrasi->kode,
            'nik' => $permohonan->registrasi->nik,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'fungsi_bangunan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->skrk->ada_bangunan,
            'koordinat' => $textKoordinat,
            'penguasaan_tanah' => $this->skrk->penguasaan_tanah,
            'jml_bangunan' => $this->skrk->jml_bangunan,
            'jml_lantai' => $this->skrk->jml_lantai,
            'luas_lantai' => $this->skrk->luas_lantai,
            'kedalaman_min' => $this->skrk->kedalaman_min,
            'kedalaman_max' => $this->skrk->kedalaman_max,
        ];

        return $this->generateDocument('3_kajian_skrk.docx', $data);
    }

    public function download4()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'tanggal_regis' => date('d F Y', strtotime($permohonan->registrasi->tanggal)),
            'kode_regis' => $permohonan->registrasi->kode,
            'nik' => $permohonan->registrasi->nik,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'npwp' => $permohonan->npwp,
            'status_modal' => $permohonan->status_modal,
            'kbli' => $permohonan->kbli,
            'judul_kbli' => $permohonan->judul_kbli,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_bangunan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'skala_usaha' => $this->skrk->skala_usaha,
            'luas_disetujui' => $this->skrk->luas_disetujui,
            'pemanfaatan_ruang' => $this->skrk->pemanfaatan_ruang,
            'peraturan_zonasi' => $this->skrk->peraturan_zonasi,
            'kbli_diizinkan' => $this->skrk->kbli_diizinkan,
            'kdb' => $this->skrk->kdb,
            'klb' => $this->skrk->klb,
            'gsb' => $this->skrk->gsb,
            'jba' => $this->skrk->jba,
            'jbb' => $this->skrk->jbb,
            'kdh' => $this->skrk->kdh,
            'ktb' => $this->skrk->ktb,
            'luas_kavling' => $this->skrk->luas_kavling,
            'jaringan_utilitas' => $this->skrk->jaringan_utilitas,
            'persyaratan_pelaksanaan' => $this->skrk->persyaratan_pelaksanaan,
        ];
        $this->koodinatTable = true;
        return $this->generateDocument('4_dokumen_skrk.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/skrk/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        if($this->koodinatTable)
        {
            $koordinatList = $this->skrk->koordinat;
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
            $this->skrk->update([
                'is_analis' => true
            ]);

            $this->skrk->permohonan->update([
                'status' => 'Proses Verifikasi'
            ]);

            // Find and update the disposisi for the 'Analisis' stage
            $tahapanAnalisId = $this->skrk->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
            if ($tahapanAnalisId) {
                $this->skrk->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->update([
                    'is_done' => true,
                    'tgl_selesai' => now()
                ]);
                $this->createRiwayat($this->skrk->permohonan, 'Selesai Analisa Data SKRK');
            }

            // Create disposisi to supervisor for 'Verifikasi' tahapan
            $tahapanVerifikasi = Tahapan::where('layanan_id', $this->skrk->permohonan->layanan_id)
                                        ->where('nama', 'Verifikasi')
                                        ->first();
            $supervisor = User::where('role', 'supervisor')->first();
            $pemberi_id = $this->skrk->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)->value('penerima_id') ?? Auth::user()->id;
            if ($tahapanVerifikasi && $supervisor) {
                $this->skrk->disposisis()->create([
                    'permohonan_id' => $this->skrk->permohonan->id,
                    'tahapan_id' => $tahapanVerifikasi->id,
                    'pemberi_id' => $pemberi_id,
                    'penerima_id' => $supervisor->id,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Mohon untuk melakukan verifikasi data hasil analisa.',
                ]);
            }

            $this->createRiwayat($this->skrk->permohonan, 'Proses Verifikasi Data SKRK');
        }

        session()->flash('success', 'Data Analis selesai!');

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
