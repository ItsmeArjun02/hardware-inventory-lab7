
@extends('layouts.app')

@section('title', 'Supplier Details')
@section('heading', 'Supplier Details')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; flex-wrap:wrap; gap:12px;">
        <div>
            <h3>{{ $supplier->company_name }}</h3>
            <p style="color:#64748b; margin-top:6px;">
                Complete supplier information
            </p>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn">
                Edit Supplier
            </a>

            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="form-grid">

        <div class="form-group">
            <label>Company Name</label>
            <p>{{ $supplier->company_name }}</p>
        </div>

        <div class="form-group">
            <label>Contact Person</label>
            <p>{{ $supplier->contact_person }}</p>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <p>{{ $supplier->email }}</p>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <p>{{ $supplier->phone }}</p>
        </div>

        <div class="form-group">
            <label>Payment Terms</label>
            <p>{{ $supplier->payment_terms ?: 'Not specified' }}</p>
        </div>

        <div class="form-group">
            <label>Lead Time</label>
            <p>{{ $supplier->lead_time }} days</p>
        </div>

        <div class="form-group">
            <label>Minimum Order Amount</label>
            <p>₱{{ number_format((float) $supplier->minimum_order_amount, 2) }}</p>
        </div>

        <div class="form-group">
            <label>Status</label>

            @if($supplier->is_active)
                <span style="color:#16a34a; font-weight:bold;">Active</span>
            @else
                <span style="color:#dc2626; font-weight:bold;">Inactive</span>
            @endif
        </div>

    </div>

    <div class="form-group">
        <label>Address</label>
        <p>{{ $supplier->address }}</p>
    </div>

    <div class="form-group">
        <label>Date Registered</label>
        <p>{{ $supplier->created_at->format('F d, Y') }}</p>
    </div>

@endsection
