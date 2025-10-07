<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture #{{ $reference }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .logo {
            max-width: 150px;
        }
        .title {
            font-size: 24px;
            color: #333;
            text-align: right;
        }
        .details {
            margin: 30px 0;
        }
        .details td {
            padding: 5px 0;
        }
        .details td:first-child {
            width: 30%;
            font-weight: bold;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table.items th {
            background: #f5f5f5;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div>
                @if(file_exists($logo))
                    <img src="{{ $logo }}" class="logo">
                @else
                    <h2>Nehemie International</h2>
                @endif
                <p>123 Rue Exemple<br>
                Paris, 75000<br>
                France</p>
            </div>
            <div class="title">
                <h1>FACTURE</h1>
                <p>N° {{ $reference }}</p>
                <p>Date: {{ $date }}</p>
            </div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>Client:</td>
                    <td>Donateur Nehemie International</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>don@nehemie-international.com</td>
                </tr>
            </table>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td style="text-align: right;">{{ $item['amount'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Total: {{ $total }}</p>
        </div>

        <div class="footer">
            <p>Merci pour votre don à Nehemie International</p>
            <p>Cette facture est une preuve de votre don et peut être utilisée à des fins fiscales.</p>
        </div>
    </div>
</body>
</html>
