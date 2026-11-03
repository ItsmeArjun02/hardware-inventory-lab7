
@extends('layouts.app')

@section('title', 'Add Supplier')
@section('heading', 'Add New Supplier')

@section('content')

<div style="margin-bottom:25px;">
    <h3>Supplier Information</h3>
    <p style="color:#64748b; margin-top:6px;">
        Enter the details of the new supplier.
    </p>
</div>

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf

    <div class="form-grid">

        <div class="form-group">
            <label>Company Name *</label>
            <input type="text" name="company_name"
                   value="{{ old('company_name') }}"
                   placeholder="Enter company name" required>
            @error('company_name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Contact Person *</label>
            <input type="text" name="contact_person"
                   value="{{ old('contact_person') }}"
                   placeholder="Enter contact person" required>
            @error('contact_person')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email Address *</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="example@email.com" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" name="phone"
                   value="{{ old('phone') }}"
                   placeholder="Enter phone number" required>
            @error('phone')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Payment Terms</label>
            <input type="text" name="payment_terms"
                   value="{{ old('payment_terms') }}"
                   placeholder="Example: 30 days">
            @error('payment_terms')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Lead Time (Days) *</label>
            <input type="number" name="lead_time"
                   value="{{ old('lead_time', 7) }}"
                   min="1" required>
            @error('lead_time')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Minimum Order Amount *</label>
            <input type="number" name="minimum_order_amount"
                   value="{{ old('minimum_order_amount', 0) }}"
                   min="0" step="0.01" required>
            @error('minimum_order_amount')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status *</label>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
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
        <textarea name="address" rows="4"
                  placeholder="Enter complete supplier address"
                  required>{{ old('address') }}</textarea>
        @error('address')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div style="display:flex; gap:10px; margin-top:25px;">
        <button type="submit" class="btn">
            Save Supplier
        </button>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</form>

@endsection
