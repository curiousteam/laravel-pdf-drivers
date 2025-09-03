<?php

namespace Curiousteam\LaravelPdfDrivers\Tests;

use Orchestra\Testbench\TestCase;
use Curiousteam\LaravelPdfDrivers\PdfServiceProvider;
use Curiousteam\LaravelPdfDrivers\Facades\Pdf;

class PdfDriverTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PdfServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['Pdf' => Pdf::class];
    }

    public function test_resolves_default_driver()
    {
        $this->app['config']->set('pdf.driver', 'mpdf');
        $driver = Pdf::driver();
        $this->assertNotNull($driver);
    }
}
