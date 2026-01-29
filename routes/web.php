<?php

use App\Livewire\Admin\Dashboard\DashboardIndex;
use App\Livewire\Admin\Disposisi\DisposisiIndex;
use App\Livewire\Admin\Gallery\GalleryIndex;
use App\Livewire\Admin\Layanan\LayananDetail;
use App\Livewire\Admin\Layanan\LayananIndex;
use App\Livewire\Admin\Pelanggaran\DashboardPelanggaran;
use App\Livewire\Admin\Pelanggaran\PelanggaranCreate;
use App\Livewire\Admin\Pelanggaran\PelanggaranDetail;
use App\Livewire\Admin\Pelanggaran\PelanggaranEdit;
use App\Livewire\Admin\Pelanggaran\PelanggaranIndex;
use App\Livewire\Admin\Pengaduan\PengaduanIndex;
use App\Livewire\Admin\Permohonan\Itr\ItrDetail;
use App\Livewire\Admin\Permohonan\Itr\ItrIndex;
use App\Livewire\Admin\Permohonan\Kkprb\KkprbDetail;
use App\Livewire\Admin\Permohonan\Kkprb\KkprbIndex;
use App\Livewire\Admin\Permohonan\Kkprnb\KkprnbDetail;
use App\Livewire\Admin\Permohonan\Kkprnb\KkprnbIndex;
use App\Livewire\Admin\Permohonan\PermohonanCreate;
use App\Livewire\Admin\Permohonan\PermohonanDetail;
use App\Livewire\Admin\Permohonan\PermohonanEdit;
use App\Livewire\Admin\Permohonan\PermohonanIndex;
use App\Livewire\Admin\Permohonan\Skrk\SkrkDetail;
use App\Livewire\Admin\Permohonan\Skrk\SkrkIndex;
use App\Livewire\Admin\Registrasi\RegistrasiIndex;
use App\Livewire\Admin\Users\UserIndex;
use App\Livewire\Guest\Layanan\ItrGuest;
use App\Livewire\Guest\Layanan\KkprbGuest;
use App\Livewire\Guest\Layanan\KkprnbGuest;
use App\Livewire\Guest\Layanan\SkrkGuest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('layanan/skrk', SkrkGuest::class)->name('layanan.skrk');
Route::get('layanan/itr', ItrGuest::class)->name('layanan.itr');
Route::get('layanan/kkprnb', KkprnbGuest::class)->name('layanan.kkprnb');
Route::get('layanan/kkprb', KkprbGuest::class)->name('layanan.kkprb');

Route::middleware(['cekRole:superadmin,supervisor,analis,surveyor,cs,data-entry'])->group(function () {
    Route::get('admin/dashboard', DashboardIndex::class)->name('dashboard'); // dashboard
    Route::get('admin/registrasi', RegistrasiIndex::class)->name('registrasi.index'); // registrasi
    Route::get('admin/registrasi/print/{id}', [RegistrasiIndex::class, 'printRegistrasi']);
});

Route::middleware(['cekRole:superadmin,supervisor,analis,surveyor,data-entry'])->group(function () {
    Route::get('admin/permohonan', PermohonanIndex::class)->name('permohonan.index'); // permohonan Index
    Route::get('admin/permohonan/create', PermohonanCreate::class)->name('permohonan.create'); // permohonan Create
    Route::get('admin/permohonan/{id}/edit', PermohonanEdit::class)->name('permohonan.edit'); // permohonan Edit
    Route::get('admin/permohonan/{id}', PermohonanDetail::class)->name('permohonan.detail'); // Permohonan Detail

    Route::get('admin/permohonan-skrk', SkrkIndex::class)->name('skrk.index');
    Route::get('admin/permohonan-skrk/{id}', SkrkDetail::class)->name('skrk.detail');

    Route::get('admin/permohonan-itr', ItrIndex::class)->name('itr.index');
    Route::get('admin/permohonan-itr/{id}', ItrDetail::class)->name('itr.detail');

    Route::get('admin/permohonan-kkprnb', KkprnbIndex::class)->name('kkprnb.index');
    Route::get('admin/permohonan-kkprnb/{id}', KkprnbDetail::class)->name('kkprnb.detail');

    Route::get('admin/permohonan-kkprb', KkprbIndex::class)->name('kkprb.index');
    Route::get('admin/permohonan-kkprb/{id}', KkprbDetail::class)->name('kkprb.detail');


    Route::get('admin/disposisi', DisposisiIndex::class)->name('disposisi.index'); // Disposisi

    Route::get('admin/pengaduan', PengaduanIndex::class)->name('pengaduan.index'); // Pengaduan

    Route::get('admin/gallery', GalleryIndex::class)->name('gallery.index'); // Gallery
});

Route::middleware(['cekRole:superadmin,supervisor'])->group(function () {
    Route::get('admin/layanan', LayananIndex::class)->name('layanan.index'); // layanan
    Route::get('admin/layanan/{id}', LayananDetail::class)->name('layanan.detail'); // layanan
});

Route::middleware(['cekRole:superadmin'])->group(function () {
    Route::get('admin/users', UserIndex::class)->name('users.index');
});

// Grup untuk Pelapor (Sistem Baru)
Route::middleware(['cekRole:admin-pelanggaran,superadmin'])->prefix('admin/pelanggaran')->group(function () {
    Route::get('/dashboard', DashboardPelanggaran::class)->name('pelanggaran.dashboard');    
    Route::get('/index', PelanggaranIndex::class)->name('pelanggaran.index');
    Route::get('/create', PelanggaranCreate::class)->name('pelanggaran.create');
    Route::get('/edit/{id}', PelanggaranEdit::class)->name('pelanggaran.edit');
    Route::get('/{id}', PelanggaranDetail::class)->name('pelanggaran.detail');
});