<?php

namespace Curiousteam\LaravelPdfDrivers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Curiousteam\LaravelPdfDrivers\Contracts\PdfDriverInterface driver(?string $driver = null)
 * @method static static loadHtml(string $html)
 * @method static static loadView(string $view, array $data = [], array $mergeData = [])
 * @method static static setPaper(string|array $size, string $orientation = 'portrait')
 * @method static static setOptions(array $options = [])
 * @method static mixed download(string $filename)
 * @method static mixed stream(string $filename)
 * @method static string save(string $path)
 */
class Pdf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'curiousteam.laravelpdfdrivers';
    }
}
