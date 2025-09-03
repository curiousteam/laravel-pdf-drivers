<?php

namespace Curiousteam\LaravelPdfDrivers;

use Illuminate\Support\Manager;
use Curiousteam\LaravelPdfDrivers\Contracts\PdfDriverInterface;
use Curiousteam\LaravelPdfDrivers\Drivers\DompdfDriver;
use Curiousteam\LaravelPdfDrivers\Drivers\MpdfDriver;
use Curiousteam\LaravelPdfDrivers\Drivers\Html2PdfDriver;
use InvalidArgumentException;

class PdfDriver extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('pdf.driver', 'mpdf');
    }

    public function driver($driver = null): PdfDriverInterface
    {
        return parent::driver($driver);
    }

    protected function createDompdfDriver(): PdfDriverInterface
    {
        return new DompdfDriver($this->config->get('pdf.drivers.dompdf', []));
    }

    protected function createMpdfDriver(): PdfDriverInterface
    {
        return new MpdfDriver($this->config->get('pdf.drivers.mpdf', []));
    }

    protected function createHtml2pdfDriver(): PdfDriverInterface
    {
        return new Html2PdfDriver($this->config->get('pdf.drivers.html2pdf', []));
    }

    public function __call($method, $parameters)
    {
        // Proxy unknown calls to default driver
        return $this->driver()->$method(...$parameters);
    }
}
