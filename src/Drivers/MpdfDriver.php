<?php

namespace Curiousteam\LaravelPdfDrivers\Drivers;

use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Curiousteam\LaravelPdfDrivers\Contracts\PdfDriverInterface;
use Illuminate\Support\Facades\View;

class MpdfDriver implements PdfDriverInterface
{
    protected Mpdf $mpdf;
    protected ?array $paper = null;

    public function __construct(array $config = [])
    {
        $this->mpdf = new Mpdf($config['options'] ?? []);
        if (!empty($config['paper'])) {
            $this->paper = $config['paper'];

            // mPDF sets paper via constructor / AddPage
            $this->applyPaper();
        }
    }

    protected function applyPaper(): void
    {
        if (!$this->paper) return;

        $size = $this->paper['size'] ?? 'A4';
        $orientation = strtolower($this->paper['orientation'] ?? 'portrait');

        // mPDF uses 'P' / 'L'
        $orientCode = $orientation === 'landscape' ? 'L' : 'P';
        $this->mpdf->AddPage($orientCode, '', '', '', '', 10, 10, 10, 10, 10, 10, $size);
    }

    public function loadHtml(string $html): static
    {
        $this->mpdf->WriteHTML($html);
        return $this;
    }

    public function loadView(string $view, array $data = [], array $mergeData = []): static
    {
        return $this->loadHtml(View::make($view, $data, $mergeData)->render());
    }

    public function setPaper(string|array $size, string $orientation = 'portrait'): static
    {
        $this->paper = is_array($size) ? ['size' => $size, 'orientation' => $orientation] : compact('size', 'orientation');
        $this->applyPaper();
        return $this;
    }

    public function setOptions(array $options = []): static
    {
        foreach ($options as $k => $v) {
            $this->mpdf->$k = $v;
        }
        return $this;
    }

    public function download(string $filename)
    {
        return $this->mpdf->Output($filename, Destination::DOWNLOAD);
    }

    public function stream(string $filename)
    {
        return $this->mpdf->Output($filename, Destination::INLINE);
    }

    public function save(string $path): string
    {
        $this->mpdf->Output($path, Destination::FILE);
        return $path;
    }
}
