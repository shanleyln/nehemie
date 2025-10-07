<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generate($reference)
    {
        $data = [
            'reference' => $reference,
            'date' => now()->format('d/m/Y'),
            'items' => [
                ['description' => 'Don Nehemie International', 'amount' => '10.00 €']
            ],
            'total' => '10.00 €',
            'logo' => public_path('images/logo.png') // Assurez-vous d'avoir un logo dans public/images/logo.png
        ];

        $pdf = \PDF::loadView('pdf.invoice', $data);
        return $pdf->download('facture-'.$reference.'.pdf');
    }
}
