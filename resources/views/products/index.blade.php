@extends('layouts.app')

@section('title', 'Product Management')
@section('heading', 'Product Management')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap;">
    <div>
        <h3>Products</h3>
        <p style="color:#64748b; margin-top:6px;">
            Manage your inventory products and stock levels.
        </p>
    </div>

<a href="{{ route('products.create') }}" class="btn">
    + Add Product
</a>
</div>

{{-- Export Products --}}
<div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:15px;">

    <a href="{{ route('exports.products.csv') }}" class="btn">
        Export Products CSV
    </a>

    <a href="{{ route('exports.products.pdf') }}" class="btn btn-secondary">
        Export Products PDF
    </a>

</div>

@if($products->count() > 0)
    <div style="overflow-x:auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Reorder Level</th>
                    <th>Unit Price</th>
                    <th>Stock Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->supplier?->company_name ?? 'No Supplier Assigned' }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->reorder_level }}</td>
                        <td>₱{{ number_format((float) $product->unit_price, 2) }}</td>

                        <td>
                            @if($product->isLowStock())
                                <span style="color:#dc2626; font-weight:bold;">
                                    Low Stock
                                </span>
                            @else
                                <span style="color:#16a34a; font-weight:bold;">
                                    In Stock
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('products.show', $product) }}" class="btn">
                                    View
                                </a>

                                <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
@else
    <div style="text-align:center; padding:50px 20px;">
        <h3>No products found</h3>

        <p style="color:#64748b; margin:12px 0 20px;">
            Start by adding your first inventory product.
        </p>

        <a href="{{ route('products.create') }}" class="btn">
            Add Your First Product
        </a>
    </div>
@endif

@endsection
