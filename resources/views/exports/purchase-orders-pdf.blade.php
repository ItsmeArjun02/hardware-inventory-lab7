
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Purchase Order Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #e5e7eb;
        }
    </style>
</head>
<body>

    <h2>Hardware Inventory</h2>
    <h3>Purchase Order Report</h3>

    <p>Generated: {{ now()->format('F d, Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Supplier</th>
                <th>Order Date</th>
                <th>Expected Delivery</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->po_number }}</td>
                    <td>{{ $order->supplier->company_name ?? 'No Supplier' }}</td>
                    <td>{{ $order->order_date?->format('M d, Y') }}</td>
                    <td>{{ $order->expected_delivery_date?->format('M d, Y') }}</td>
                    <td>PHP {{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
