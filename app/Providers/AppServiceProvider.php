<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Cek jika aplikasi berjalan di server Production (cPanel)
        if (config('app.env') === 'production') {
            // Paksa HTTPS di cPanel jika SSL sudah aktif
            URL::forceScheme('https');
            
            // Atur jalur folder publik khusus untuk di cPanel saja
            $this->app->usePublicPath(base_path('../dokmutu.uin-alauddin.com'));
        }
        
        // Jika di lokal (env=local), Laravel akan otomatis menggunakan 
        // folder public bawaannya sendiri tanpa diganggu kode di atas.
    }
}