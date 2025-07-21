<?php

use App\Livewire\Admin\Dashboard\DashboardIndex;
use App\Livewire\Admin\Users\UserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
// });

Route::middleware(['cekRole:superadmin,admin,user'])->group(function () {
    Route::get('admin/dashboard', DashboardIndex::class)->name('dashboard'); // admin dashboard
});

Route::middleware(['cekRole:superadmin'])->group(function () {
    Route::get('admin/users', UserIndex::class)->name('users.index');
});
