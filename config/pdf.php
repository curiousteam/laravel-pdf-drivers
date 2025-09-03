<?php

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
            'paper' => ['size' => 'A4', 'orientation' => 'portrait'],
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
