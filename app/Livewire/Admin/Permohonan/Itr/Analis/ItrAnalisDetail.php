<?php

namespace App\Livewire\Admin\Permohonan\Itr\Analis;

use Livewire\Component;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use PhpOffice\PhpWord\TemplateProcessor;

class ItrAnalisDetail extends Component
{
    public $itr;
    public $koordinatTable = false;

    #[On('refresh-itr-analis-list')]
    public function refresh()
    {
       
    }
    
    public function render()
    {
        return view('livewire.admin.permohonan.itr.analis.itr-analis-detail');
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::find($itr_id);
    }

    public function download2()
    {
        $permohonan = $this->itr->permohonan;
        $textKoordinat = '';
        if($this->itr->koordinat){
            foreach ($this->itr->koordinat as $i => $point) {
                $textKoordinat .= "{$point['x']}, {$point['y']}\n";
            }
        }

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'tanggal_regis' => $permohonan->registrasi->tanggal ? date('d F Y', strtotime($permohonan->registrasi->tanggal)) : '-',
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
            'koordinat' => $textKoordinat,
            'penguasaan_tanah' => $this->itr->penguasaan_tanah,
            'skala_usaha' => $this->itr->skala_usaha,
            'luas_disetujui' => $this->itr->luas_disetujui,
            'pemanfaatan_ruang' => $this->itr->pemanfaatan_ruang,
            'peraturan_zonasi' => $this->itr->peraturan_zonasi,
            'kbli_diizinkan' => $this->itr->kbli_diizinkan,
            'kdb' => $this->itr->kdb,
            'klb' => $this->itr->klb,
            'gsb' => $this->itr->gsb,
            'jba' => $this->itr->jba,
            'jbb' => $this->itr->jbb,
            'kdh' => $this->itr->kdh,
            'ktb' => $this->itr->ktb,
            'luas_kavling' => $this->itr->luas_kavling,
            'jaringan_utilitas' => $this->itr->jaringan_utilitas,
            'persyaratan_pelaksanaan' => $this->itr->persyaratan_pelaksanaan,
        ];

        $this->koordinatTable = true;

        if($this->itr->jenis_itr == 'ITR')
        {
            return $this->generateDocument('3_template_itr.docx', $data);
        }
        elseif($this->itr->jenis_itr == 'ITR-KKKPR')
        {
            return $this->generateDocument('3_template_itr_kkkpr.docx', $data);
        }
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/itr/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        if($this->koordinatTable)
        {
            $koordinatList = $this->itr->koordinat;
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
            $this->itr->update([
                'is_analis' => true
            ]);

            $this->itr->permohonan->update([
                'status' => 'Proses Verifikasi'
            ]);

            // Find and update the disposisi for the 'Analisis' stage
            $tahapanAnalisId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
            if ($tahapanAnalisId) {
                $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->update([
                    'is_done' => true,
                    'tgl_selesai' => now()
                ]);
                $this->createRiwayat($this->itr->permohonan, 'Selesai Analisa Data ITR');
            }

            // Create disposisi to supervisor for 'Verifikasi' tahapan
            $tahapanVerifikasi = Tahapan::where('layanan_id', $this->itr->permohonan->layanan_id)
                                        ->where('nama', 'Verifikasi')
                                        ->first();
            $supervisor = User::where('role', 'supervisor')->first();
            $pemberi_id = $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)->value('penerima_id') ?? Auth::user()->id;
            if ($tahapanVerifikasi && $supervisor) {
                $this->itr->disposisis()->create([
                    'permohonan_id' => $this->itr->permohonan->id,
                    'tahapan_id' => $tahapanVerifikasi->id,
                    'pemberi_id' => $pemberi_id,
                    'penerima_id' => $supervisor->id,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Mohon untuk melakukan verifikasi data hasil analisa.',
                ]);
            }

            $this->createRiwayat($this->itr->permohonan, 'Proses Verifikasi Data ITR');
        }

        session()->flash('success', 'Data Analis selesai!');

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
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
