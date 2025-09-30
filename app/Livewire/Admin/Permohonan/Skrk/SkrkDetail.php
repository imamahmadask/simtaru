<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Disposisi;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Detail SKRK')]
class SkrkDetail extends Component
{
    use WithFileUploads;

    public $skrk;
    public $count_verifikasi;
    public $persyaratan_berkas;
    public $file_ = [];

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.skrk-detail');
    }

    public function mount($id)
    {
        $this->skrk = Skrk::findOrFail($id);
        $this->count_verifikasi = $this->skrk->permohonan->berkas->where('status', '!=', 'diterima')->count();

        $tahapan_id = $this->skrk->permohonan->layanan->tahapan->where('nama', 'Cetak')->value('id');
        $this->persyaratan_berkas = $this->skrk->permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_id);
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

                $tahapan = Tahapan::where('layanan_id', $this->skrk->permohonan->layanan_id)->where('urutan', 3)->first();

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

    public function uploadDokumenFix()
    {
        $no_reg = $this->skrk->registrasi->kode;

        foreach ($this->skrk->permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/skrk_form_survey
                $path = $uploadedFile->storeAs(
                    'skrk/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->skrk->permohonan->id,
                        'persyaratan_berkas_id'=> $item->id,
                    ],
                    [
                        'file_path'           => $path,
                        'uploaded_by'         => Auth::id(),
                        'uploaded_at'         => now(),
                        'status'              => 'menunggu',
                        'catatan_verifikator' => null,
                    ]
                );
            }
        }

        $this->skrk->permohonan->update([
            'status' => 'Success',
        ]);

        $this->createRiwayat($this->skrk->permohonan, 'Dokumen SKRK selesai!');

        session()->flash('success', 'Dokumen SKRK Fix berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
    }
}
