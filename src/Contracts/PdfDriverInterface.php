<?php

namespace Curiousteam\LaravelPdfDrivers\Contracts;

interface PdfDriverInterface
{
    public function loadHtml(string $html): static;

    public function loadView(string $view, array $data = [], array $mergeData = []): static;

    public function setPaper(string|array $size, string $orientation = 'portrait'): static;

    public function setOptions(array $options = []): static;

    public function download(string $filename);

    public function stream(string $filename);

    public function save(string $path): string; // return saved path
}
