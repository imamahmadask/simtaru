<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    public $search = '';
    public $filterLayanan = '';    
    public $layanans;

    #[On('refresh-registrasi-list')]
    public function refresh()
    {}

    public function render()
    {
        $registrasis = Registrasi::with('layanan')
            ->when($this->filterLayanan, function ($query) {
                $query->whereHas('layanan', function ($subQuery) {
                    $subQuery->where('id', 'like', '%' . $this->filterLayanan . '%');
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('nama', 'like', '%' . $this->search . '%')
                             ->orWhere('kode', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.registrasi.registrasi-index', [
            'registrasis' => $registrasis
        ]);
    }

    public function deleteRegistrasi(Registrasi $registrasi)
    {
        if (Auth::user()->role != 'superadmin') {
            abort(403);
        }

        $registrasi->permohonan()->delete();
        $registrasi->delete();

        session()->flash('message', 'Registrasi berhasil dihapus');

        return redirect()->route('registrasi.index');
    }

    public function mount()
    {
        $this->layanans = Layanan::orderBy('nama', 'asc')->get();
    }

    public function printRegistrasi($id)
    {
        $data = Registrasi::with('layanan')->find($id);

        view()->share('data', $data);

        // $pdf = Pdf::loadView('pdf.tanda-terima-regis');
        $pdf = Pdf::loadView('pdf.bukti-regis');
        return $pdf->download($data['kode'].'.pdf');
    }

    public function downloadTandaTerima($id)
    {
        $data = Registrasi::with('layanan')->find($id);

        $data = [
            'kode_registrasi' => $data->kode,
            'nama_pemohon' => $data->nama,
            'alamat_tanah' => $data->alamat_tanah.', '.$data->kel_tanah.', '.$data->kec_tanah,
            'fungsi_bangunan' => $data->fungsi_bangunan,
            'tgl_permohonan' => date('d-m-Y', strtotime($data->tanggal)),
            'jenis_layanan' => $data->layanan->nama,
            'penerima' => $data->createdBy->name
        ];

        return $this->generateDocument('Tanda_terima_registrasi.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(storage_path('app/public/templates/skrk/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

}
