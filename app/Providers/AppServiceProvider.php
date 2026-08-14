<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Proteksi Keamanan: Blokir seluruh perintah destruktif DB (migrate:fresh, db:wipe, dll) di Production
        DB::prohibitDestructiveCommands($this->app->isProduction());
    }
}
