<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function viewPDF()
    {
        $mpdf = new Mpdf();
        $html = view('pdf.index')->render();  // Mengambil view pdf/index

        $mpdf->WriteHTML($html);
        return $mpdf->Output('event-buka-bersama.pdf', 'I'); // Output untuk view di browser
    }

    public function downloadPDF()
    {
        $mpdf = new Mpdf();
        $html = view('pdf.index')->render();  // Mengambil view pdf/index

        $mpdf->WriteHTML($html);
        return $mpdf->Output('event-buka-bersama.pdf', 'D'); // Output untuk download file
    }
}