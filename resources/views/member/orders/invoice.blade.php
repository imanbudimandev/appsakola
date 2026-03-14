<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $paperSize = \App\Models\Setting::get('invoice_paper_size', 'a4');
        $isThermal = str_contains($paperSize, 'thermal');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace; /* For thermal font feel if thermal */
            @if(!$isThermal)
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            @endif
            margin: 0;
            padding: {{ $isThermal ? '5px' : '30px' }};
            color: #333;
            background: {{ $isThermal ? '#fff' : '#f5f5f5' }};
        }
        
        .invoice-box {
            margin: auto;
            background: #fff;
            @if($paperSize == 'a4')
                max-width: 210mm;
                min-height: 297mm;
                padding: 40px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            @elseif($paperSize == 'folio')
                max-width: 215mm;
                min-height: 330mm;
                padding: 40px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            @elseif($paperSize == 'thermal_80')
                max-width: 80mm;
                padding: 10px;
                box-shadow: none;
                border: none;
            @elseif($paperSize == 'thermal_58')
                max-width: 58mm;
                padding: 5px;
                box-shadow: none;
                border: none;
            @endif
        }

        .header-table, .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: {{ $isThermal ? '15px' : '40px' }};
            border: none;
            table-layout: fixed;
        }
        
        .header-table td, .details-table td {
            padding: 0;
            vertical-align: top;
            border: none;
        }

        /* Thermal Specific Styles */
        @if($isThermal)
            .logo {
                text-align: center;
                margin-bottom: 10px;
                display: block !important;
            }
            .logo img {
                max-height: 40px;
                display: block;
                margin: 0 auto 5px;
            }
            .logo span {
                font-size: 16px;
                display: block;
                font-weight: bold;
            }
            .invoice-title-thermal {
                text-align: center;
                border-top: 1px dashed #333;
                border-bottom: 1px dashed #333;
                margin: 10px 0;
                padding: 5px 0;
            }
            .invoice-title-thermal h1 {
                font-size: 18px;
                margin: 0;
            }
            .details h3 {
                font-size: 12px;
                border: none !important;
                margin: 10px 0 2px;
            }
            .details p {
                font-size: 11px !important;
            }
            table.items-table {
                font-size: 11px;
            }
            table.items-table th {
                border-bottom: 1px dashed #333 !important;
                background: transparent !important;
                padding: 5px 0 !important;
            }
            table.items-table td {
                padding: 5px 0 !important;
                border-bottom: 1px dashed #eee !important;
            }
            .total-table {
                width: 100% !important;
                font-size: 12px;
            }
            .grand-total {
                font-size: 14px !important;
                border-top: 1px dashed #333 !important;
            }
            .footer {
                font-size: 10px !important;
                margin-top: 20px !important;
                border-top: 1px dashed #333 !important;
            }
        @else
            /* A4/Folio Styles */
            .logo {
                display: flex;
                align-items: center;
                font-size: 26px;
                font-weight: bold;
                color: #333;
                gap: 15px;
            }
            .logo img {
                max-height: 70px;
                width: auto;
            }
            .invoice-title h1 {
                margin: 0;
                color: #333;
                font-size: 28px;
                text-transform: uppercase;
            }
            .invoice-title p {
                margin: 5px 0 0;
                color: #777;
                font-size: 14px;
            }
            .details h3 {
                margin-bottom: 10px;
                font-size: 14px;
                text-transform: uppercase;
                color: #999;
                border-bottom: 1px solid #eee;
                padding-bottom: 5px;
                width: 90%;
            }
            .details p {
                margin: 2px 0;
                line-height: 1.5;
                font-size: 14px;
            }
            table.items-table th {
                background: #f9fafb;
                text-align: left;
                padding: 12px 15px;
                border-bottom: 2px solid #eee;
                color: #666;
                font-size: 13px;
                text-transform: uppercase;
            }
            table.items-table td {
                padding: 15px;
                border-bottom: 1px solid #eee;
                vertical-align: middle;
            }
            .total-table {
                width: 250px;
            }
            .grand-total {
                font-size: 18px;
                font-weight: bold;
                color: #4f46e5;
                border-top: 2px solid #eee;
            }
            .status-badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                margin-top: 10px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .paid { background: #d1fae5 !important; color: #065f46 !important; }
            .unpaid { background: #fef3c7 !important; color: #92400e !important; }
            .cancelled { background: #fee2e2 !important; color: #991b1b !important; }
        @endif

        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .item-name {
            font-weight: bold;
            color: #333;
        }
        .total-section {
            display: flex;
            justify-content: flex-end;
        }
        .total-table td {
            padding: 8px 0;
            border-bottom: none;
        }
        
        .footer {
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }

        .print-btn {
            background: #4f46e5;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        @media print {
            @page {
                @if($paperSize == 'a4')
                    size: A4;
                    margin: 10mm;
                @elseif($paperSize == 'folio')
                    size: 215mm 330mm;
                    margin: 10mm;
                @elseif($isThermal)
                    size: auto;
                    margin: 0;
                @endif
            }
            .print-btn { display: none; }
            body { padding: 0; margin: 0; background: #fff; }
            .invoice-box { border: none !important; box-shadow: none !important; padding: {{ $isThermal ? '0' : '10px' }}; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <a href="javascript:window.print()" class="print-btn">Print Invoice</a>
    </div>

    <div class="invoice-box">
        {{-- Header Section --}}
        @if($isThermal)
            <div class="logo">
                @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo">
                @endif
                <span>{{ \App\Models\Setting::get('site_name', 'Appsakola') }}</span>
            </div>
            <div class="invoice-title-thermal">
                <h1>INVOICE</h1>
                <p style="font-size: 12px; margin: 2px 0;">#{{ $order->order_number }}</p>
            </div>
        @else
            <table class="header-table">
                <tr>
                    <td>
                        <div class="logo">
                            @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo">
                            @endif
                            <span>{{ \App\Models\Setting::get('site_name', 'Appsakola') }}</span>
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="invoice-title">
                            <h1>Invoice</h1>
                            <p>#{{ $order->order_number }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        @endif

        {{-- Details Section --}}
        @if($isThermal)
            <div class="details">
                <p>Tanggal: {{ $order->created_at->format('d/m/y H:i') }}</p>
                <p>Pelanggan: {{ $order->user->name }}</p>
                <p>Pembayaran: {{ $order->payment_method == 'midtrans' ? 'Midtrans' : 'Manual' }}</p>
                <p>Status: <strong>{{ $order->payment_status == 'paid' ? 'LUNAS' : 'PENDING' }}</strong></p>
            </div>
        @else
            <table class="details-table">
                <tr>
                    <td style="width: 50%;">
                        <div class="details">
                            <h3>INFO PENAGIHAN</h3>
                            <p><strong>{{ $order->user->name }}</strong></p>
                            <p>{{ $order->user->email }}</p>
                            <p>Status Pembayaran:</p>
                            <span class="status-badge {{ $order->payment_status == 'paid' ? 'paid' : ($order->status == 'cancelled' ? 'cancelled' : 'unpaid') }}">
                                {{ $order->payment_status == 'paid' ? 'Lunas' : ($order->status == 'cancelled' ? 'Dibatalkan' : 'Belum Bayar') }}
                            </span>
                        </div>
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <div class="details">
                            <h3>INFO TRANSAKSI</h3>
                            <p>Tanggal: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
                            <p>Waktu: {{ $order->created_at->format('H:i') }} WIB</p>
                            <p>Metode: <strong>{{ $order->payment_method == 'midtrans' ? 'Midtrans' : 'Transfer Bank' }}</strong></p>
                        </div>
                    </td>
                </tr>
            </table>
        @endif

        {{-- Items Section --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: {{ $isThermal ? '50%' : '60%' }}; text-align: left;">Item</th>
                    @if(!$isThermal) <th style="text-align: center;">Qty</th> @endif
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <span class="item-name">{{ $item->product->name }}</span>
                        @if($isThermal) <br><small>1 x Rp {{ number_format($item->price, 0, ',', '.') }}</small> @endif
                    </td>
                    @if(!$isThermal) <td style="text-align: center;">1</td> @endif
                    <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total Section --}}
        <div class="total-section">
            <table class="total-table">
                @if(!$isThermal)
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align: right;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td><strong>TOTAL</strong></td>
                    <td style="text-align: right;"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Footer Section --}}
        <div class="footer">
            <p>{{ \App\Models\Setting::get('invoice_note', 'Terima kasih atas pembelian Anda!') }}</p>
            @if(!$isThermal)
                <p>{{ \App\Models\Setting::get('site_name', 'Appsakola') }} - Digital Asset Solutions</p>
            @endif
        </div>
    </div>
</body>
</html>
