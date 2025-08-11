<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
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
    <h1>Invoice</h1>

    <table>
        <tr>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($booking->slot_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>${{ $booking->price }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td class="status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</td>
        </tr>
    </table>
</body>
</html>

