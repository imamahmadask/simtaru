<?php

use App\Livewire\Admin\Dashboard\DashboardIndex;
use App\Livewire\Admin\Permohonan\PermohonanCreate;
use App\Livewire\Admin\Permohonan\PermohonanEdit;
use App\Livewire\Admin\Permohonan\PermohonanIndex;
use App\Livewire\Admin\Registrasi\RegistrasiIndex;
use App\Livewire\Admin\Users\UserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['cekRole:superadmin,admin,user'])->group(function () {
    Route::get('admin/dashboard', DashboardIndex::class)->name('dashboard'); // dashboard
    Route::get('admin/registrasi', RegistrasiIndex::class)->name('registrasi.index'); // registrasi

    Route::get('admin/permohonan', PermohonanIndex::class)->name('permohonan.index'); // permohonan Index
    Route::get('admin/permohonan/create', PermohonanCreate::class)->name('permohonan.create'); // permohonan Create
    Route::get('admin/permohonan/{id}/edit', PermohonanEdit::class)->name('permohonan.edit'); // permohonan Edit
});

Route::middleware(['cekRole:superadmin'])->group(function () {
    Route::get('admin/users', UserIndex::class)->name('users.index');
});
