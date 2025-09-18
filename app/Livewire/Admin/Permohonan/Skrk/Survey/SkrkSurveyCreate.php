<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class SkrkSurveyCreate extends Component
{
    use WithFileUploads;

    public $tahapans, $users, $permohonan_id, $skrk_id, $catatan;

    #[Validate('required')]
    public $tahapan_id, $penerima_id;

    #[Validate('required')]
    public $tgl_survey;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];

    public $file_ = [];

    public $koordinat = [];

    public function render()
    {
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $tahapan_id = $permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        $persyaratan_berkas = $permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_id);

        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-create', [
            'persyaratan_berkas' => $persyaratan_berkas
        ]);
    }

    public function createSurvey()
    {
        $this->validate();

        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $skrk = Skrk::findOrFail($this->skrk_id);
        $no_reg = $skrk->registrasi->kode;

        foreach ($permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/skrk_form_survey
                $path = $uploadedFile->storeAs(
                    'skrk_form_survey/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->permohonan_id,
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

        if($this->foto_survey) {
            $foto_survey_path = [];
            foreach ($this->foto_survey as $foto) {
                $foto_survey_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_survey_path[] = $foto->storeAs('skrk_foto_survey', $foto_survey_filename, 'public');
            }
        }
        else
        {
            $foto_survey_path = null;
        }

        // update tabel survey
        $skrk->update([
           'tgl_survey' => $this->tgl_survey,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path,
           'is_survey' => true
        ]);

        $this->createRiwayat($permohonan, 'Entry Data Survey');

        Disposisi::create([
            'permohonan_id' => $permohonan->id,
            'tahapan_id' => $this->tahapan_id,
            'pemberi_id' => Auth::user()->id,
            'penerima_id' => $this->penerima_id,
            'catatan' => $this->catatan
        ]);

        $this->createRiwayat($permohonan, "Disposisi kepada {$this->users->where('id', $this->penerima_id)->first()->name} pada tahapan Analis Berkas");

        session()->flash('success', 'Data Survey berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;
        $skrk = Skrk::find($this->skrk_id);
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $this->tahapans = Tahapan::where('layanan_id', $permohonan->layanan_id)->where('urutan', 2)->get();
        $this->users = User::where('role', 'analis')->get();

         $this->koordinat = $skrk->koordinat ?? [
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''], // minimal 4
        ];
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }

    public function addRow()
    {
        if (count($this->koordinat) < 8) {
            $this->koordinat[] = ['x' => '', 'y' => ''];
        }
    }

    public function removeRow($index)
    {
        if (count($this->koordinat) > 4) { // minimal 4 titik
            unset($this->koordinat[$index]);
            $this->koordinat = array_values($this->koordinat);
        }
    }
}
