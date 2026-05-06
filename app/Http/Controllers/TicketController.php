<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function generatePDF($id)
    {
        $vente = Vente::findOrFail($id);
        $vente->load('ligneVentes.medicament');

        // Générer le QR code
        $qrCode = new QrCode(
            'Vente ID: ' . $vente->id . ' - Total: ' . $vente->total . ' FCFA',
            new Encoding('UTF-8'),
            ErrorCorrectionLevel::Low,
            100,
            10
        );

        $writer = new SvgWriter();
        $result = $writer->write($qrCode);
        $qrCodeDataUri = $result->getDataUri();

        $pdf = PDF::loadView('tickets.ticket', ['vente' => $vente, 'qrCode' => $qrCodeDataUri])
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 5)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5);

        return $pdf->download('ticket_vente_' . $vente->id . '.pdf');
    }
}
