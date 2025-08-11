{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slot Invoice</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Active Slot Invoice</h2>
    </div>

    <table>
        <tr>
            <th>Slot Date</th>
            <td>{{ \Carbon\Carbon::parse($invoice['slot_date'])->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Start Time</th>
            <td>{{ $invoice['start_time'] }}</td>
        </tr>
        <tr>
            <th>End Time</th>
            <td>{{ $invoice['end_time'] }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $invoice['status'] }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>₹{{ number_format($invoice['price'], 2) }}</td>
        </tr>
    </table>

    <p><strong>Note:</strong> This slot is currently active and not yet booked.</p>
</body>
</html> --}}


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Active Slot Invoice</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; margin-bottom: 30px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-cancelled {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Active Slot Invoice</h1>

    <table>
        <tr>
            <th>Slot Date</th>
            <td>{{ \Carbon\Carbon::parse($invoice['slot_date'])->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ \Carbon\Carbon::parse($invoice['start_time'])->format('h:i A') }} - {{ \Carbon\Carbon::parse($invoice['end_time'])->format('h:i A') }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>${{ $invoice['price'] }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td class="status-{{ strtolower($invoice['status']) }}">{{ ucfirst($invoice['status']) }}</td>
        </tr>
    </table>

    <p><strong>Note:</strong> This slot is currently active and not yet booked.</p>
</body>
</html>

