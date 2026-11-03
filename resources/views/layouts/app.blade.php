
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hardware Inventory System')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #263247;
        }

        .sidebar {
            width: 245px;
            min-height: 100vh;
            background: #17243b;
            color: white;
            position: fixed;
            padding: 28px 18px;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 7px;
            margin-bottom: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2d4162;
            color: white;
        }

        .sidebar form {
            margin-top: 25px;
        }

        .logout-btn {
            width: 100%;
            display: block;
            color: #cbd5e1;
            background: transparent;
            border: none;
            text-align: left;
            padding: 13px 14px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        .logout-btn:hover {
            background: #7f1d1d;
            color: white;
        }

        .main {
            margin-left: 245px;
            padding: 35px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .content {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            padding: 11px 17px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #64748b;
        }

        .btn-danger {
            background: #dc2626;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        .table th {
            background: #f8fafc;
            color: #475569;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .alert {
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 20px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main {
                margin-left: 0;
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">

        <div class="brand">Hardware Inventory</div>

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('suppliers.index') }}"
           class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            Suppliers
        </a>

        <a href="{{ route('suppliers.performance') }}"
   class="{{ request()->routeIs('suppliers.performance') ? 'active' : '' }}">
    Supplier Performance
</a>

        <a href="{{ route('products.index') }}"
           class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            Products
        </a>

        <a href="{{ route('purchase-orders.index') }}"
           class="{{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}">
            Purchase Orders
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>

    </aside>

    <main class="main">

        <div class="topbar">
            <h2>@yield('heading', 'Dashboard')</h2>
            <span>Inventory Management</span>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert" style="background:#fee2e2;color:#991b1b;">
                Please check the form for errors.
            </div>
        @endif

        <section class="content">
            @yield('content')
        </section>

    </main>

</body>
</html>
