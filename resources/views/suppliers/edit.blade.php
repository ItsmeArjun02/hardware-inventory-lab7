
@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('heading', 'Edit Supplier')

@section('content')

<div style="margin-bottom:25px;">
    <h3>Update Supplier Information</h3>
    <p style="color:#64748b; margin-top:6px;">
        Modify the supplier details below.
    </p>
</div>

<form action="{{ route('suppliers.update', $supplier) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-grid">

        <div class="form-group">
            <label>Company Name *</label>
            <input type="text" name="company_name"
                   value="{{ old('company_name', $supplier->company_name) }}" required>
            @error('company_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Contact Person *</label>
            <input type="text" name="contact_person"
                   value="{{ old('contact_person', $supplier->contact_person) }}" required>
            @error('contact_person')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email Address *</label>
            <input type="email" name="email"
                   value="{{ old('email', $supplier->email) }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" name="phone"
                   value="{{ old('phone', $supplier->phone) }}" required>
            @error('phone')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Payment Terms</label>
            <input type="text" name="payment_terms"
                   value="{{ old('payment_terms', $supplier->payment_terms) }}">
            @error('payment_terms')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Lead Time (Days) *</label>
            <input type="number" name="lead_time"
                   value="{{ old('lead_time', $supplier->lead_time) }}"
                   min="1" required>
            @error('lead_time')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Minimum Order Amount *</label>
            <input type="number" name="minimum_order_amount"
                   value="{{ old('minimum_order_amount', $supplier->minimum_order_amount) }}"
                   min="0" step="0.01" required>
            @error('minimum_order_amount')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status *</label>
            <select name="is_active" required>
                <option value="1"
                    {{ old('is_active', $supplier->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ old('is_active', $supplier->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
            @error('is_active')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="form-group">
        <label>Address *</label>
        <textarea name="address" rows="4" required>{{ old('address', $supplier->address) }}</textarea>
        @error('address')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div style="display:flex; gap:10px; margin-top:25px;">
        <button type="submit" class="btn">
            Update Supplier
        </button>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</form>

@endsection
