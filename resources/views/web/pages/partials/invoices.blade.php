
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Invoice #{{ $invoice['invoice_no'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 10mm 15mm;
            position: relative;
            font-size: 12px;
            background: #fff;
        }

        /* Decorative shapes */
        .left-shape {
            position: absolute;
            top: -200px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: #009688;
            transform: rotate(45deg);
            z-index: -5;
        }

        .right-shape {
            position: absolute;
            bottom: -200px;
            right: -80px;
            width: 220px;
            height: 220px;
            background: #e91e63;
            transform: rotate(45deg);
            z-index: -5;
        }

        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }

        .inv-title {
            font-size: 40px;
            letter-spacing: 6px;
            color: #333;
            font-weight: 700;
        }

        .company-block {
            text-align: right;
            font-size: 13px;
        }

        .company-block .name {
            font-weight: 700;
            font-size: 18px;
            color: #4a2b2b;
        }

        .meta {
            margin-top: 14px;
            background: #fff;
            padding: 10px 14px;
            border-radius: 6px;
            display: inline-block;
            border: 1px solid #eee;
        }

        /* Client + Invoice Info */
        .head-rows {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .client,
        .invoice-info {
            flex: 1;
            min-width: 220px;
        }

        .box {
            border: 1px solid #eee;
            padding: 18px;
            border-radius: 8px;
            background: #fff;
            page-break-inside: avoid;
        }

        .box h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #666;
            font-weight: 700;
        }

        .box p {
            margin: 2px 0;
            color: #333;
            font-size: 13px;
        }

        /* Items */
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 22px;
            margin-bottom: 18px;
            background: #fff;
            page-break-inside: avoid;
        }

        .items th,
        .items td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 13px;
        }

        .items thead th {
            background: #f7f7f7;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            color: #666;
        }

        .items tbody tr:last-child td {
            border-bottom: none;
        }

        /* Totals */
        .totals {
            margin-top: 10px;
            width: 100%;
            max-width: 420px;
            float: right;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .totals td {
            padding: 6px 8px;
            font-size: 13px;
        }

        .totals .label {
            color: #666;
        }

        .totals .value {
            text-align: right;
            font-weight: 700;
            font-size: 15px;
        }

        /* Notes */
        .notes {
            clear: both;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-end;
            page-break-inside: avoid;
        }

        .bank {
            font-size: 13px;
            color: #444;
        }

        .signature {
            text-align: right;
            font-size: 13px;
        }

        .sig-line {
            display: inline-block;
            margin-top: 18px;
            border-top: 1px solid #ddd;
            padding-top: 6px;
            font-weight: 700;
            color: #333;
        }

        @media (max-width:600px) {
            .inv-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .company-block {
                text-align: left;
                margin-top: 8px;
            }

            .totals {
                float: none;
                max-width: 100%;
            }

            .notes {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="left-shape"></div>
    <div class="right-shape"></div>

    <div class="inv-header">
        <div>
            <div class="inv-title">INVOICE</div>
        </div>
        <div class="company-block">
            <img src="{{ public_path('assets/admin/img/logo.png') }}" alt="Tender Moments Logo"
             style="width:130px;">
            <div style="margin-top:8px;">ABN: 52 114 429 886</div>
            <div style="margin-top:6px;">Contact: {{ $invoice['business_email'] }}</div>
            <div style="margin-top:6px;">Service provided: Sensual Energy Session</div>
        </div>
    </div>
    <div class="head-rows">
        <div class="client box">
            <h4>Issued To</h4>
            <p><strong>{{ $invoice['user']['name'] }}</strong></p>
            @if ($invoice['user']['email'])
                <p>{{ $invoice['user']['email'] }}</p>
            @endif
            <p style="margin-top:10px; font-size:12px; color:#777;">
                Residency: <strong>{{ $invoice['residency'] }}</strong>
            </p>
        </div>

        <div class="invoice-info box">
            <h4>Invoice Details</h4>
            <p>Invoice #: <strong>{{ $invoice['invoice_no'] }}</strong></p>
            <p>Slot ID: <strong>{{ $invoice['slot_id'] }}</strong></p>
            <p>Date of Session: <strong>{{ \Carbon\Carbon::parse($invoice['slot_date'])->format('d M Y') }}</strong></p>
            <p>Time: <strong>{{ \Carbon\Carbon::parse($invoice['start_time'])->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($invoice['end_time'])->format('h:i A') }}</strong></p>
            <p>Status: <strong>{{ ucfirst($invoice['status']) }}</strong></p>
        </div>
    </div>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>Slot Date</th>
                <th>Slot Time</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sensual Energy Session</td>
                <td>{{ \Carbon\Carbon::parse($invoice['slot_date'])->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice['start_time'])->format('h:i A') }} -
                    {{ \Carbon\Carbon::parse($invoice['end_time'])->format('h:i A') }}</td>
                <td class="value">${{ number_format($invoice['total'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="bank">
        <h4>Payment Details</h4>
        <p><strong>For Australian residents:</strong> ${{ number_format($invoice['price'] * 1.1, 2) }} (10% GST
            included)</p>
        <p><strong>For Non-Australian residents:</strong> ${{ number_format($invoice['price'], 2) }} (No GST)</p>
    </div>

    <div class="signature">
        <div class="signed-name">{{ $invoice['user']['name'] }}</div>
        <div class="sig-line">Authorized Signature</div>
    </div>
</body>

</html>
