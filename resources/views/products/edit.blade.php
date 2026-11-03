
@extends('layouts.app')

@section('title', 'Edit Product')
@section('heading', 'Edit Product')

@section('content')

<div style="margin-bottom:25px;">
    <h3>Update Product Information</h3>
    <p style="color:#64748b; margin-top:6px;">
        Modify product details, stock levels, and replenishment information.
    </p>
</div>

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-grid">

        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="product_name"
                   value="{{ old('product_name', $product->product_name) }}" required>
            @error('product_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>SKU *</label>
            <input type="text" name="sku"
                   value="{{ old('sku', $product->sku) }}" required>
            @error('sku')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Supplier *</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category"
                   value="{{ old('category', $product->category) }}">
            @error('category')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Quantity *</label>
            <input type="number" name="quantity"
                   value="{{ old('quantity', $product->quantity) }}"
                   min="0" required>
            @error('quantity')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Reorder Level *</label>
            <input type="number" name="reorder_level"
                   value="{{ old('reorder_level', $product->reorder_level) }}"
                   min="0" required>
            @error('reorder_level')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Average Daily Usage *</label>
            <input type="number" name="average_daily_usage"
                   value="{{ old('average_daily_usage', $product->average_daily_usage) }}"
                   min="0" step="0.01" required>
            @error('average_daily_usage')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Safety Stock *</label>
            <input type="number" name="safety_stock"
                   value="{{ old('safety_stock', $product->safety_stock) }}"
                   min="0" required>
            @error('safety_stock')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Unit Price (₱) *</label>
            <input type="number" name="unit_price"
                   value="{{ old('unit_price', $product->unit_price) }}"
                   min="0" step="0.01" required>
            @error('unit_price')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div style="display:flex; gap:10px; margin-top:25px;">
        <button type="submit" class="btn">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@endsection
