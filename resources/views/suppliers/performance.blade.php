
@extends('layouts.app')

@section('title', 'Supplier Performance')

@section('heading', 'Supplier Performance Tracking')

@section('content')

    <h3>Supplier Performance Report</h3>

    <p style="color:#64748b; margin-top:8px;">
        Monitor supplier products, purchase orders, and order values.
    </p>

    <div style="overflow-x:auto;">

        <table class="table">

            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Total Products</th>
                    <th>Total Orders</th>
                    <th>Approved</th>
                    <th>Pending</th>
                    <th>Rejected</th>
                    <th>Approved Amount</th>
                </tr>
            </thead>

            <tbody>

                @forelse($performance as $item)

                    <tr>
                        <td>
                            {{ $item['supplier']->company_name }}
                        </td>

                        <td>
                            {{ $item['total_products'] }}
                        </td>

                        <td>
                            {{ $item['total_orders'] }}
                        </td>

                        <td style="color:#16a34a; font-weight:bold;">
                            {{ $item['approved_orders'] }}
                        </td>

                        <td style="color:#d97706; font-weight:bold;">
                            {{ $item['pending_orders'] }}
                        </td>

                        <td style="color:#dc2626; font-weight:bold;">
                            {{ $item['rejected_orders'] }}
                        </td>

                        <td>
                            ₱{{ number_format($item['approved_amount'], 2) }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            No supplier records available.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div style="margin-top:25px;">
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Back to Suppliers
        </a>
    </div>

@endsection
