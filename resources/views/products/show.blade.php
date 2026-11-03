
@extends('layouts.app')

@section('title', 'Product Details')
@section('heading', 'Product Details')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap; margin-bottom:25px;">
    <div>
        <h3>{{ $product->product_name }}</h3>
        <p style="color:#64748b; margin-top:6px;">
            Product information and inventory details.
        </p>
    </div>

    <div style="display:flex; gap:10px;">
        <a href="{{ route('products.edit', $product) }}" class="btn">Edit Product</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="form-grid">

    <div class="form-group">
        <label>Product Name</label>
        <p>{{ $product->product_name }}</p>
    </div>

    <div class="form-group">
        <label>SKU</label>
        <p>{{ $product->sku }}</p>
    </div>

    <div class="form-group">
        <label>Supplier</label>
        <p>{{ $product->supplier->company_name ?? 'N/A' }}</p>
    </div>

    <div class="form-group">
        <label>Category</label>
        <p>{{ $product->category ?? 'N/A' }}</p>
    </div>

    <div class="form-group">
        <label>Current Quantity</label>
        <p>{{ $product->quantity }}</p>
    </div>

    <div class="form-group">
        <label>Reorder Level</label>
        <p>{{ $product->reorder_level }}</p>
    </div>

    <div class="form-group">
        <label>Average Daily Usage</label>
        <p>{{ number_format((float) $product->average_daily_usage, 2) }} units/day</p>
    </div>

    <div class="form-group">
        <label>Supplier Lead Time</label>
        <p>{{ $product->supplier->lead_time ?? 0 }} days</p>
    </div>

    <div class="form-group">
        <label>Safety Stock</label>
        <p>{{ $product->safety_stock }} units</p>
    </div>

<div class="form-group">
    <label>Calculated Reorder Point</label>
    <p style="font-weight:bold; color:#2563eb;">
        {{ number_format($reorderPoint, 2) }} units
    </p>
</div>

    <div class="form-group">
        <label>Unit Price</label>
        <p>₱{{ number_format((float) $product->unit_price, 2) }}</p>
    </div>

    <div class="form-group">
    <label>Stock Status</label>

    @if($needsReordering)
        <p style="color:#dc2626; font-weight:bold;">Reordering Required</p>
    @else
        <p style="color:#16a34a; font-weight:bold;">Stock Sufficient</p>
    @endif
</div>

    <div class="form-group">
        <label>Date Created</label>
        <p>{{ $product->created_at->format('F d, Y h:i A') }}</p>
    </div>

</div>

<div class="form-group" style="margin-top:15px;">
    <label>Description</label>
    <p>{{ $product->description ?: 'No description provided.' }}</p>
</div>

@endsection
