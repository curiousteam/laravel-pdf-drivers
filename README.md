# Driver-based PDF generator for Laravel (mPDF, Dompdf, Html2Pdf) with a unified API.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/curiousteam/laravel-pdf-drivers.svg?style=flat-square)](https://packagist.org/packages/curiousteam/laravel-pdf-drivers)
[![Total Downloads](https://img.shields.io/packagist/dt/curiousteam/laravel-pdf-drivers.svg?style=flat-square)](https://packagist.org/packages/curiousteam/laravel-pdf-drivers)

A simple, driver-based PDF generation manager for Laravel.  
Supports multiple PDF libraries (drivers) such as **mPDF**, **Dompdf**, **TCPDF**, and more.  

## Installation

You can install the package via composer:

```bash
composer require curiousteam/laravel-pdf-drivers
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Curiousteam\LaravelPdfDrivers\PdfServiceProvider" --tag="config"
```

If you are on Laravel < 5.5, you need to manually register the service provider:

```php
// config/app.php
'providers' => [
    Curiousteam\LaravelPdfDrivers\PdfServiceProvider::class,
],
```

---

## Configuration

After publishing, you’ll get a config file at `config/pdf.php`:

```php
return [

    'driver' => env('PDF_DRIVER', 'mpdf'), // dompdf|mpdf|html2pdf

    'drivers' => [

        'dompdf' => [
            'options' => [
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ],
            'paper' => ['size' => 'A4', 'orientation' => 'portrait'],
        ],

        'mpdf' => [
            'options' => [
                'mode' => 'utf-8',
                'format' => 'A4',
                'tempDir' => storage_path('app/mpdf-temp'),
                'default_font' => 'dejavusans',
            ],
            'paper' => ['size' => 'A4', 'orientation' => 'landscape'],
        ],

        'html2pdf' => [
            'options' => [
                'format' => 'A4',
                'orientation' => 'P',
                'language' => 'en',
                'unicode' => true,
                'encoding' => 'UTF-8',
                'margins' => [10, 10, 10, 10],
            ],
            'paper' => ['size' => 'A4', 'orientation' => 'portrait'],
        ],

    ],

];
```

---

## Usage

### Basic Example

```php
use Curiousteam\LaravelPdfDrivers\Facades\Pdf;

Route::get('/download-report', function () {
    $html = view('templates.pdf.reports.example', ['title' => 'Laravel PDF Driver'])->render();

    return Pdf::loadHTML($html)
        ->download('report.pdf');
});
```

### Streaming PDF in Browser

```php
return Pdf::loadView('templates.pdf.reports.invoice', ['invoice' => $invoice])
    ->stream('invoice.pdf');
```

### Saving PDF to Disk

```php
Pdf::loadHTML('<h1>Hello CuriousTeam</h1>')
    ->save(storage_path('app/reports/hello.pdf'));
```

---

## Switching Drivers

Default installed driver is: **mpdf**

To use other driver (```Dompdf\Dompdf``` or ```Spipu\Html2Pdf```), you need to install the package via composer first:

```bash
composer require dompdf/dompdf
```

Or,


```bash
composer require spipu/html2pdf
```

Then, you can easily switch drivers at runtime:

```php
$pdf = Pdf::driver('dompdf')
    ->loadView('reports.test')
    ->download('test.pdf');
```

Or, even dynamically in `.env`:

```env
PDF_DRIVER=dompdf
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Curious Team](https://github.com/curiousteam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
