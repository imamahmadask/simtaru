<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrasiCreate extends Component
{
    public $layanans;

    #[Validate('required')]
    public $nama, $no_hp, $layanan_id, $tanggal, $fungsi_bangunan, $alamat_tanah, $kel_tanah, $kec_tanah;

    #[Validate('required|min:0,max:16|numeric')]
    public $nik;

    #[Validate('required|email')]
    public $email;

    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-create');
    }

    public function createRegistrasi()
    {
        $this->validate();

        $year         = date('Y');
        $month        = date('m');
        $layanan_kode = Layanan::findOrFail($this->layanan_id)->kode;

        // ─────────────────────────────────────────────────────────────────
        // Generate kode registrasi menggunakan DB Transaction + Lock
        //
        // ATURAN:
        // 1. Menggunakan MAX + 1 — nomor yang pernah dihapus TIDAK dipakai ulang.
        //    Contoh: kode terakhir = 100, maka kode baru = 101.
        //
        // 2. Counter GLOBAL — semua jenis layanan (SKRK, ITR, KKPRB, KKPRNB)
        //    berbagi satu urutan nomor yang sama dalam satu tahun.
        //    Contoh: 0100-kkprnb → berikutnya 0101-skrk (bukan kembali ke 1).
        //
        // 3. lockForUpdate() mencegah race condition saat dua user
        //    submit registrasi bersamaan (tidak akan duplikat kode).
        // ─────────────────────────────────────────────────────────────────
        $newKode = DB::transaction(function () use ($year, $month, $layanan_kode) {

            // Kunci dan ambil nomor urutan tertinggi dari SEMUA layanan (termasuk yang di-soft-delete) tahun ini
            $lastKode = Registrasi::withTrashed()
                ->whereYear('created_at', $year)
                ->lockForUpdate()
                ->pluck('kode')
                ->map(function ($kode) {
                    // Ambil bagian pertama sebagai angka urutan
                    return (int) explode('-', $kode)[0];
                })
                ->max();

            // Nomor berikutnya = MAX yang ada + 1 (atau mulai dari 1 jika belum ada)
            $sequence = ($lastKode ?? 0) + 1;

            return str_pad($sequence, 4, '0', STR_PAD_LEFT)
                . '-' . $layanan_kode
                . '-' . $month
                . '-' . $year;
        });

        DB::transaction(function () use ($newKode) {
            $registrasi = Registrasi::create([
                'kode'                => $newKode,
                'nama'                => $this->nama,
                'nik'                 => $this->nik,
                'no_hp'               => $this->no_hp,
                'tanggal'             => $this->tanggal,
                'layanan_id'          => $this->layanan_id,
                'created_by'          => Auth::user()->id,
                'email'               => $this->email,
                'fungsi_bangunan'     => $this->fungsi_bangunan,
                'alamat_tanah'        => $this->alamat_tanah,
                'kel_tanah'           => $this->kel_tanah,
                'kec_tanah'           => $this->kec_tanah,
            ]);

            RiwayatPermohonan::create([
                'registrasi_id' => $registrasi->id,
                'user_id'       => Auth::user()->id,
                'keterangan'    => 'Entry Registrasi',
            ]);
        });

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data registrasi berhasil ditambahkan!',
        ]);

        $this->reset('nama', 'nik', 'no_hp', 'email', 'tanggal', 'layanan_id', 'fungsi_bangunan', 'alamat_tanah', 'kel_tanah', 'kec_tanah');

        $this->dispatch('refresh-registrasi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount()
    {
        $this->layanans = Layanan::orderBy('nama', 'ASC')->get();
    }
}

