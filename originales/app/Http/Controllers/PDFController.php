<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $content = request()->input('content');

        $pdf = PDF::loadView('pdf.document', compact('content'));

        $pdf->save(storage_path('app/public/document.pdf'));

        // Envía el archivo PDF a la API REST de DCM4CHEE-ARC
        $client = new Client();

        $apiUrl = Config::get('app.dcm4chee_arc_api_url');

        $response = $client->post($apiUrl, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen(storage_path('app/public/document.pdf'), 'r'),
                    'filename' => 'document.pdf',
                ],
            ],
        ]);

        // Maneja la respuesta de la API REST de DCM4CHEE-ARC según tus necesidades

        return redirect()->route('editor');
    }
}

