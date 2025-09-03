<?php

namespace Curiousteam\LaravelPdfDrivers;

use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pdf.php', 'pdf');

        $this->app->singleton('curiousteam.laravelpdfdrivers', function ($app) {
            return new PdfDriver($app);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/pdf.php' => config_path('pdf.php'),
        ], 'config');
    }
}
