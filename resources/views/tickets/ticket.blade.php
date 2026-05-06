<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Vente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .ticket-container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #333;
            padding: 20px;
            text-align: center;
        }
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #0066cc;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .info-section {
            text-align: left;
            margin-bottom: 15px;
            font-size: 12px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
        }
        .info-section p {
            margin: 3px 0;
        }
        .items-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
            font-size: 11px;
        }
        .items-table th {
            background-color: #f0f0f0;
            border-bottom: 1px solid #333;
            padding: 5px;
            text-align: left;
        }
        .items-table td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .items-table .price {
            text-align: right;
        }
        .items-table .qty {
            text-align: center;
        }
        .totals {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
            text-align: right;
            font-weight: bold;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 13px;
        }
        .total-amount {
            font-size: 16px;
            color: #0066cc;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
        .thank-you {
            font-weight: bold;
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- En-tête -->
        <div class="header">
            <h1>GESTION PHARMACIE</h1>
            <p>Pharmacie Management System</p>
            <p>Ticket de Vente #{{ str_pad($vente->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Informations de la vente -->
        <div class="info-section">
            <p><strong>Date:</strong> {{ $vente->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Vendeur:</strong> {{ $vente->vendeur ?? 'N/A' }}</p>
        </div>

        <!-- Tableau des articles -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th class="qty">Qté</th>
                    <th class="price">P.U</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vente->ligneVentes as $ligne)
                    <tr>
                        <td>{{ $ligne->medicament->nom_commercial }}</td>
                        <td class="qty">{{ $ligne->quantite }}</td>
                        <td class="price">{{ number_format($ligne->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="price">{{ number_format($ligne->quantite * $ligne->prix, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="totals">
            <div class="total-row">
                <span>Sous-total:</span>
                <span>{{ number_format($vente->total, 0, ',', ' ') }} FCFA</span>
            </div>
            @php
                $reimbursed = 0;
                foreach ($vente->ligneVentes as $ligne) {
                    if ($ligne->medicament->remboursable) {
                        $reimbursed += ($ligne->quantite * $ligne->prix) * ($ligne->medicament->taux_remboursement / 100);
                    }
                }
            @endphp
            @if($reimbursed > 0)
            <div class="total-row">
                <span>Montant remboursé:</span>
                <span>{{ number_format($reimbursed, 0, ',', ' ') }} FCFA</span>
            </div>
            @endif
            <div class="total-row total-amount">
                <span>TOTAL:</span>
                <span>{{ number_format($vente->total, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>=====================================</p>
            <div style="text-align: center; margin: 10px 0;">
                <img src="{{ $qrCode }}" alt="QR Code" style="width: 80px; height: 80px;" />
            </div>
            <p class="thank-you">Merci pour votre achat!</p>
            <p>À bientôt!</p>
            <p>Generated: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
