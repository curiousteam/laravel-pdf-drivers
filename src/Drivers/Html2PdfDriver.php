<?php

namespace Curiousteam\LaravelPdfDrivers\Drivers;

use Spipu\Html2Pdf\Html2Pdf;
use Curiousteam\LaravelPdfDrivers\Contracts\PdfDriverInterface;
use Illuminate\Support\Facades\View;

class Html2PdfDriver implements PdfDriverInterface
{
    protected Html2Pdf $pdf;

    public function __construct(array $config = [])
    {
        $opts = $config['options'] ?? [];
        $this->pdf = new Html2Pdf(
            $opts['orientation'] ?? 'P',
            $opts['format'] ?? 'A4',
            $opts['language'] ?? 'en',
            $opts['unicode'] ?? true,
            $opts['encoding'] ?? 'UTF-8',
            $opts['margins'] ?? [10, 10, 10, 10]
        );
    }

    public function loadHtml(string $html): static
    {
        $this->pdf->writeHTML($html);
        return $this;
    }

    public function loadView(string $view, array $data = [], array $mergeData = []): static
    {
        return $this->loadHtml(View::make($view, $data, $mergeData)->render());
    }

    public function setPaper(string|array $size, string $orientation = 'portrait'): static
    {
        // INFO: Html2Pdf sets paper via constructor
        // TODO: Need to recreate instance or document in README
        return $this;
    }

    public function setOptions(array $options = []): static
    {
        // INFO: Limited dynamic options; document recommended usage via config
        return $this;
    }

    public function download(string $filename)
    {
        return $this->pdf->output($filename, 'D');
    }

    public function stream(string $filename)
    {
        return $this->pdf->output($filename, 'I');
    }

    public function save(string $path): string
    {
        $this->pdf->output($path, 'F');
        return $path;
    }
}
