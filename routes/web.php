<?php

use App\Livewire\Admin\Dashboard\DashboardIndex;
use App\Livewire\Admin\Disposisi\DisposisiIndex;
use App\Livewire\Admin\Layanan\LayananDetail;
use App\Livewire\Admin\Layanan\LayananIndex;
use App\Livewire\Admin\Permohonan\PermohonanCreate;
use App\Livewire\Admin\Permohonan\PermohonanDetail;
use App\Livewire\Admin\Permohonan\PermohonanEdit;
use App\Livewire\Admin\Permohonan\PermohonanIndex;
use App\Livewire\Admin\Permohonan\Skrk\SkrkDetail;
use App\Livewire\Admin\Permohonan\Skrk\SkrkIndex;
use App\Livewire\Admin\Registrasi\RegistrasiIndex;
use App\Livewire\Admin\Users\UserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['cekRole:superadmin,supervisor,analis,surveyor,cs,data-entry'])->group(function () {
    Route::get('admin/dashboard', DashboardIndex::class)->name('dashboard'); // dashboard
    Route::get('admin/registrasi', RegistrasiIndex::class)->name('registrasi.index'); // registrasi
});

Route::middleware(['cekRole:superadmin,supervisor,analis,surveyor,data-entry'])->group(function () {
    Route::get('admin/permohonan', PermohonanIndex::class)->name('permohonan.index'); // permohonan Index
    Route::get('admin/permohonan/create', PermohonanCreate::class)->name('permohonan.create'); // permohonan Create
    Route::get('admin/permohonan/{id}/edit', PermohonanEdit::class)->name('permohonan.edit'); // permohonan Edit
    Route::get('admin/permohonan/{id}', PermohonanDetail::class)->name('permohonan.detail'); // Permohonan Detail

    Route::get('admin/permohonan-skrk', SkrkIndex::class)->name('skrk.index');
    Route::get('admin/permohonan-skrk/{id}', SkrkDetail::class)->name('skrk.detail');

    Route::get('admin/disposisi', DisposisiIndex::class)->name('disposisi.index'); // Disposisi
});

Route::middleware(['cekRole:superadmin,supervisor'])->group(function () {
    Route::get('admin/layanan', LayananIndex::class)->name('layanan.index'); // layanan
    Route::get('admin/layanan/{id}', LayananDetail::class)->name('layanan.detail'); // layanan
});

Route::middleware(['cekRole:superadmin'])->group(function () {
    Route::get('admin/users', UserIndex::class)->name('users.index');
});
