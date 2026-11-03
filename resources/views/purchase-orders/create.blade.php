@extends('layouts.app')

@section('title', 'Create Purchase Order')
@section('heading', 'Create Purchase Order')

@section('content')

<div style="margin-bottom:20px;">
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">
        ← Back to Purchase Orders
    </a>
</div>

@if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px;">
        <strong>Please correct the following errors:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('purchase-orders.store') }}" method="POST">
    @csrf

    <div style="background:white; padding:25px; border-radius:10px; margin-bottom:20px;">

        <h3 style="margin-bottom:20px;">Purchase Order Information</h3>

        <div style="margin-bottom:15px;">
            <label>Supplier</label>
            <select name="supplier_id" id="supplier_id" required
                    style="width:100%; padding:10px; margin-top:6px;">
                <option value="">Select Supplier</option>

                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:15px;">

            <div>
                <label>Order Date</label>
                <input type="date" name="order_date"
                       value="{{ old('order_date', date('Y-m-d')) }}"
                       required
                       style="width:100%; padding:10px; margin-top:6px;">
            </div>

            <div>
                <label>Expected Delivery Date</label>
                <input type="date" name="expected_delivery_date"
                       value="{{ old('expected_delivery_date') }}"
                       style="width:100%; padding:10px; margin-top:6px;">
            </div>

        </div>

        <div style="margin-top:15px;">
            <label>Notes</label>
            <textarea name="notes" rows="3"
                      style="width:100%; padding:10px; margin-top:6px;">{{ old('notes') }}</textarea>
        </div>
    </div>

    <div style="background:white; padding:25px; border-radius:10px;">

        <h3 style="margin-bottom:15px;">Products to Order</h3>

        <p style="color:#64748b; margin-bottom:15px;">
            Select products from the chosen supplier and enter the order quantity and unit cost.
        </p>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f5f9; text-align:left;">
                        <th style="padding:10px;">Product</th>
                        <th style="padding:10px;">Quantity</th>
                        <th style="padding:10px;">Unit Cost (₱)</th>
                        <th style="padding:10px;">Action</th>
                    </tr>
                </thead>

                <tbody id="productRows">
                    <tr>
                        <td style="padding:8px;">
                            <select name="products[0][product_id]" required
                                    class="product-select"
                                    style="width:100%; padding:10px;">
                                <option value="">Select Product</option>

                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                            data-supplier="{{ $product->supplier_id }}"
                                            data-price="{{ $product->unit_price }}">
                                        {{ $product->product_name }} ({{ $product->sku }})
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td style="padding:8px;">
                            <input type="number" name="products[0][quantity]"
                                   min="1" value="1" required
                                   style="width:100%; padding:10px;">
                        </td>

                        <td style="padding:8px;">
                            <input type="number" name="products[0][unit_cost]"
                                   min="0" step="0.01" required
                                   style="width:100%; padding:10px;">
                        </td>

                        <td style="padding:8px;">
                            <button type="button" class="btn btn-danger remove-row">
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <button type="button" id="addProduct" class="btn btn-secondary"
                style="margin-top:15px;">
            + Add Another Product
        </button>

        <div style="margin-top:25px; text-align:right;">
            <button type="submit" class="btn">
                Create Purchase Order
            </button>
        </div>

    </div>
</form>

<script>
    let productIndex = 1;

    const productRows = document.getElementById('productRows');
    const supplierSelect = document.getElementById('supplier_id');

    function updateProductOptions() {
        const selectedSupplier = supplierSelect.value;

        document.querySelectorAll('.product-select').forEach(select => {
            Array.from(select.options).forEach(option => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                option.hidden = selectedSupplier !== ''
                    && option.dataset.supplier !== selectedSupplier;
            });

            if (select.selectedOptions[0]?.hidden) {
                select.value = '';
            }
        });
    }

    supplierSelect.addEventListener('change', updateProductOptions);

    document.getElementById('addProduct').addEventListener('click', function () {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td style="padding:8px;">
                <select name="products[${productIndex}][product_id]"
                        required class="product-select"
                        style="width:100%; padding:10px;">
                    <option value="">Select Product</option>

                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                                data-supplier="{{ $product->supplier_id }}"
                                data-price="{{ $product->unit_price }}">
                            {{ $product->product_name }} ({{ $product->sku }})
                        </option>
                    @endforeach
                </select>
            </td>

            <td style="padding:8px;">
                <input type="number"
                       name="products[${productIndex}][quantity]"
                       min="1" value="1" required
                       style="width:100%; padding:10px;">
            </td>

            <td style="padding:8px;">
                <input type="number"
                       name="products[${productIndex}][unit_cost]"
                       min="0" step="0.01" required
                       style="width:100%; padding:10px;">
            </td>

            <td style="padding:8px;">
                <button type="button" class="btn btn-danger remove-row">
                    Remove
                </button>
            </td>
        `;

        productRows.appendChild(row);
        productIndex++;
        updateProductOptions();
    });

    productRows.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-row')) {
            const rows = productRows.querySelectorAll('tr');

            if (rows.length > 1) {
                event.target.closest('tr').remove();
            } else {
                alert('At least one product is required.');
            }
        }
    });

    productRows.addEventListener('change', function (event) {
        if (event.target.classList.contains('product-select')) {
            const option = event.target.selectedOptions[0];
            const price = option.dataset.price;

            if (price !== undefined) {
                const costInput = event.target.closest('tr')
                    .querySelector('input[name$="[unit_cost]"]');

                costInput.value = price;
            }
        }
    });

    updateProductOptions();
</script>

@endsection