<?php

namespace Curiousteam\LaravelPdfDrivers\Drivers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Curiousteam\LaravelPdfDrivers\Contracts\PdfDriverInterface;
use Illuminate\Support\Facades\View;

class DompdfDriver implements PdfDriverInterface
{
    protected Dompdf $dompdf;
    protected ?array $paper = null;

    public function __construct(array $config = [])
    {
        $options = new Options();
        foreach (($config['options'] ?? []) as $k => $v) {
            $options->set($k, $v);
        }
        $this->dompdf = new Dompdf($options);

        if (!empty($config['paper'])) {
            $this->paper = $config['paper'];
        }
    }

    public function loadHtml(string $html): static
    {
        $this->dompdf->loadHtml($html);
        return $this;
    }

    public function loadView(string $view, array $data = [], array $mergeData = []): static
    {
        return $this->loadHtml(View::make($view, $data, $mergeData)->render());
    }

    public function setPaper(string|array $size, string $orientation = 'portrait'): static
    {
        $this->paper = is_array($size) ? ['size' => $size, 'orientation' => $orientation] : compact('size', 'orientation');
        return $this;
    }

    public function setOptions(array $options = []): static
    {
        foreach ($options as $k => $v) {
            $this->dompdf->getOptions()->set($k, $v);
        }
        return $this;
    }

    protected function render(): void
    {
        if ($this->paper) {
            $size = $this->paper['size'];
            $orientation = $this->paper['orientation'] ?? 'portrait';
            $this->dompdf->setPaper($size, $orientation);
        }
        $this->dompdf->render();
    }

    public function download(string $filename)
    {
        $this->render();
        return $this->dompdf->stream($filename, ['Attachment' => true]);
    }

    public function stream(string $filename)
    {
        $this->render();
        return $this->dompdf->stream($filename, ['Attachment' => false]);
    }

    public function save(string $path): string
    {
        $this->render();
        file_put_contents($path, $this->dompdf->output());
        return $path;
    }
}
