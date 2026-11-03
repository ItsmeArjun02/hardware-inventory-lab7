
@extends('layouts.app')

@section('title', 'Add Product')
@section('heading', 'Add New Product')

@section('content')

<div style="margin-bottom:25px;">
    <h3>Product Information</h3>
    <p style="color:#64748b; margin-top:6px;">
        Enter product details, stock levels, and replenishment information.
    </p>
</div>

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div class="form-grid">

        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="product_name"
                   value="{{ old('product_name') }}"
                   placeholder="Enter product name" required>
            @error('product_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>SKU *</label>
            <input type="text" name="sku"
                   value="{{ old('sku') }}"
                   placeholder="Example: IT-001" required>
            @error('sku') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Supplier *</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category"
                   value="{{ old('category') }}"
                   placeholder="Example: Computer Accessories">
            @error('category') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Quantity *</label>
            <input type="number" name="quantity"
                   value="{{ old('quantity', 0) }}"
                   min="0" required>
            @error('quantity') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Reorder Level *</label>
            <input type="number" name="reorder_level"
                   value="{{ old('reorder_level', 5) }}"
                   min="0" required>
            @error('reorder_level') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Average Daily Usage *</label>
            <input type="number" name="average_daily_usage"
                   value="{{ old('average_daily_usage', 0) }}"
                   min="0" step="0.01" required>
            @error('average_daily_usage') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Safety Stock *</label>
            <input type="number" name="safety_stock"
                   value="{{ old('safety_stock', 0) }}"
                   min="0" required>
            @error('safety_stock') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Unit Price (₱) *</label>
            <input type="number" name="unit_price"
                   value="{{ old('unit_price', 0) }}"
                   min="0" step="0.01" required>
            @error('unit_price') <div class="error">{{ $message }}</div> @enderror
        </div>

    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4"
                  placeholder="Enter product description">{{ old('description') }}</textarea>
        @error('description') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div style="display:flex; gap:10px; margin-top:25px;">
        <button type="submit" class="btn">Save Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@endsection
