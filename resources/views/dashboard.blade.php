<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hardware Inventory Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        h1 {
            margin: 0 0 8px;
        }

        .subtitle {
            color: #64748b;
            margin: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            margin: 0 0 15px;
            color: #64748b;
            font-size: 16px;
        }

        .number {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            color: #2563eb;
        }

        .links {
            margin-top: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .logout {
            background: #dc2626;
            border: none;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Hardware Inventory Dashboard</h1>
            <p class="subtitle">
                Inventory and Purchase Order Overview
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">
                Logout
            </button>
        </form>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Total Suppliers</h3>
            <p class="number">{{ $totalSuppliers }}</p>
        </div>

        <div class="card">
            <h3>Total Products</h3>
            <p class="number">{{ $totalProducts }}</p>
        </div>

        <div class="card">
            <h3>Pending Purchase Orders</h3>
            <p class="number">{{ $pendingOrders }}</p>
        </div>

        <div class="card">
            <h3>Products to Reorder</h3>
            <p class="number">{{ $productsToReorder }}</p>
        </div>

    </div>

    <div class="links">
        <a href="{{ route('suppliers.index') }}" class="btn">
            Manage Suppliers
        </a>

        <a href="{{ route('products.index') }}" class="btn">
            Manage Products
        </a>

        <a href="{{ route('purchase-orders.index') }}" class="btn">
            Purchase Orders
        </a>
    </div>

</div>

</body>
</html>