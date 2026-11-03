
@extends('layouts.app')

@section('title', 'Purchase Orders')
@section('heading', 'Purchase Order Management')

@section('content')

<div style="margin-bottom:25px;">

    {{-- Page Header and Main Actions --}}
    <div style="display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap;">

        <div>
            <h3>Purchase Orders</h3>
            <p style="color:#64748b; margin-top:6px;">
                Manage supplier orders and inventory replenishment.
            </p>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">

            <form action="{{ route('purchase-orders.generate') }}" method="POST"
                  onsubmit="return confirm('Generate Purchase Orders for all products that need replenishment?');">
                @csrf

                <button type="submit" class="btn btn-secondary">
                    Generate Automatic PO
                </button>
            </form>

            <a href="{{ route('purchase-orders.create') }}" class="btn">
                + Create Purchase Order
            </a>

        </div>

    </div>

    {{-- Export Purchase Orders --}}
    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:15px;">

        <a href="{{ route('exports.purchase-orders.csv') }}" class="btn">
            Export Purchase Orders CSV
        </a>

        <a href="{{ route('exports.purchase-orders.pdf') }}" class="btn btn-secondary">
            Export Purchase Orders PDF
        </a>

    </div>

</div>

{{-- Success Message --}}
@if(session('success'))
    <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:8px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif

{{-- Purchase Orders Table --}}
<div style="overflow-x:auto;">

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f1f5f9; text-align:left;">
                <th style="padding:12px;">PO Number</th>
                <th style="padding:12px;">Supplier</th>
                <th style="padding:12px;">Order Date</th>
                <th style="padding:12px;">Expected Delivery</th>
                <th style="padding:12px;">Total Amount</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($purchaseOrders as $purchaseOrder)

                <tr style="border-bottom:1px solid #e2e8f0;">

                    <td style="padding:12px;">
                        {{ $purchaseOrder->po_number }}
                    </td>

                    <td style="padding:12px;">
                        {{ $purchaseOrder->supplier->company_name ?? 'N/A' }}
                    </td>

                    <td style="padding:12px;">
                        {{ $purchaseOrder->order_date->format('M d, Y') }}
                    </td>

                    <td style="padding:12px;">
                        {{ $purchaseOrder->expected_delivery_date
                            ? $purchaseOrder->expected_delivery_date->format('M d, Y')
                            : 'Not specified' }}
                    </td>

                    <td style="padding:12px;">
                        ₱{{ number_format((float) $purchaseOrder->total_amount, 2) }}
                    </td>

                    <td style="padding:12px;">
                        {{ ucfirst($purchaseOrder->status) }}
                    </td>

                    <td style="padding:12px;">

                        <div style="display:flex; gap:8px; flex-wrap:wrap;">

                            <a href="{{ route('purchase-orders.show', $purchaseOrder) }}"
                               class="btn btn-secondary">
                                View
                            </a>

                            @if($purchaseOrder->status === 'pending')

                                <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}"
                                   class="btn">
                                    Edit
                                </a>

                                <form action="{{ route('purchase-orders.destroy', $purchaseOrder) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this Purchase Order?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" style="padding:25px; text-align:center; color:#64748b;">
                        No Purchase Orders found. Create your first Purchase Order.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Pagination --}}
<div style="margin-top:20px;">
    {{ $purchaseOrders->links() }}
</div>

@endsection
