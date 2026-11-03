
@extends('layouts.app')

@section('title', 'Purchase Order Details')
@section('heading', 'Purchase Order Details')

@section('content')

<div style="display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">
        ← Back to Purchase Orders
    </a>

    @if($purchaseOrder->status === 'pending')
        <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="btn">
            Edit Purchase Order
        </a>
    @endif
</div>

<div style="background:white; padding:25px; border-radius:10px;">

    @if(session('success'))
        <p style="color:green;">
            {{ session('success') }}
        </p>
    @endif

    @if($errors->any())
        <p style="color:red;">
            {{ $errors->first() }}
        </p>
    @endif

    <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:15px; margin-bottom:25px;">
        <div>
            <h2>{{ $purchaseOrder->po_number }}</h2>
            <p style="color:#64748b;">Purchase Order Information</p>
        </div>

        <div>
            <strong>Status:</strong>
            <span style="padding:6px 12px; border-radius:6px; background:#fef3c7; color:#92400e;">
                {{ ucfirst($purchaseOrder->status) }}
            </span>
        </div>
    </div>

    @can('approve', $purchaseOrder)
        <div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

            <form method="POST"
                  action="{{ route('purchase-orders.approve', $purchaseOrder) }}"
                  onsubmit="return confirm('Approve this Purchase Order?');">
                @csrf
                <button type="submit" class="btn">
                    Approve Purchase Order
                </button>
            </form>

            <form method="POST"
                  action="{{ route('purchase-orders.reject', $purchaseOrder) }}"
                  onsubmit="return confirm('Reject this Purchase Order?');">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Reject Purchase Order
                </button>
            </form>

        </div>
    @endcan

    <hr style="border:0; border-top:1px solid #e2e8f0; margin-bottom:20px;">

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:20px;">

        <div>
            <strong>Supplier</strong>
            <p>{{ $purchaseOrder->supplier?->company_name ?? 'Supplier not available' }}</p>
        </div>

        <div>
            <strong>Contact Person</strong>
            <p>{{ $purchaseOrder->supplier?->contact_person ?? 'N/A' }}</p>
        </div>

        <div>
            <strong>Supplier Email</strong>
            <p>{{ $purchaseOrder->supplier?->email ?? 'N/A' }}</p>
        </div>

        <div>
            <strong>Order Date</strong>
            <p>{{ $purchaseOrder->order_date->format('F d, Y') }}</p>
        </div>

        <div>
            <strong>Expected Delivery Date</strong>
            <p>
                {{ $purchaseOrder->expected_delivery_date
                    ? $purchaseOrder->expected_delivery_date->format('F d, Y')
                    : 'Not specified' }}
            </p>
        </div>

        <div>
            <strong>Total Amount</strong>
            <p style="font-size:20px; font-weight:bold; color:#2563eb;">
                ₱{{ number_format((float) $purchaseOrder->total_amount, 2) }}
            </p>
        </div>

    </div>

    <h3 style="margin-top:30px; margin-bottom:15px;">Ordered Products</h3>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f1f5f9; text-align:left;">
                    <th style="padding:12px;">Product</th>
                    <th style="padding:12px;">SKU</th>
                    <th style="padding:12px;">Quantity</th>
                    <th style="padding:12px;">Unit Cost</th>
                    <th style="padding:12px;">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse($purchaseOrder->products as $product)
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:12px;">{{ $product->product_name }}</td>
                        <td style="padding:12px;">{{ $product->sku }}</td>
                        <td style="padding:12px;">{{ $product->pivot->quantity }}</td>
                        <td style="padding:12px;">
                            ₱{{ number_format((float) $product->pivot->unit_cost, 2) }}
                        </td>
                        <td style="padding:12px;">
                            ₱{{ number_format(
                                $product->pivot->quantity * $product->pivot->unit_cost,
                                2
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:15px; text-align:center;">
                            No products found in this Purchase Order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="text-align:right; margin-top:20px;">
        <h3>
            Total: ₱{{ number_format((float) $purchaseOrder->total_amount, 2) }}
        </h3>
    </div>

    @if($purchaseOrder->notes)
        <div style="margin-top:25px;">
            <strong>Notes</strong>
            <p>{{ $purchaseOrder->notes }}</p>
        </div>
    @endif

</div>

@endsection
