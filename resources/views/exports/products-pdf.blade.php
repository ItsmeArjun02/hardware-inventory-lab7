
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Inventory Report</title>

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
    <h3>Product Inventory Report</h3>

    <p>Generated: {{ now()->format('F d, Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Supplier</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Reorder Level</th>
                <th>Unit Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->supplier->company_name ?? 'No Supplier' }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->reorder_level }}</td>
                    <td>PHP {{ number_format($product->unit_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
