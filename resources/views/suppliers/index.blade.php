
@extends('layouts.app')

@section('title', 'Supplier Management')
@section('heading', 'Supplier Management')

@section('content')

    <div style="display:flex; justify-content:space-between; align-items:center; gap:15px; flex-wrap:wrap;">
        <div>
            <h3>Suppliers</h3>
            <p style="color:#64748b; margin-top:6px;">
                Manage your registered suppliers.
            </p>
        </div>

        <a href="{{ route('suppliers.create') }}" class="btn">
            + Add Supplier
        </a>
    </div>

    @if($suppliers->count() > 0)

        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Lead Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->company_name }}</td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->lead_time }} days</td>

                            <td>
                                @if($supplier->is_active)
                                    <span style="color:#16a34a; font-weight:bold;">
                                        Active
                                    </span>
                                @else
                                    <span style="color:#dc2626; font-weight:bold;">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                       class="btn">
                                        View
                                    </a>

                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                       class="btn btn-secondary">
                                        Edit
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this supplier?');">

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
            {{ $suppliers->links() }}
        </div>

    @else

        <div style="text-align:center; padding:50px 20px;">
            <h3>No suppliers found</h3>

            <p style="color:#64748b; margin:12px 0 20px;">
                Start by adding your first supplier.
            </p>

            <a href="{{ route('suppliers.create') }}" class="btn">
                Add Your First Supplier
            </a>
        </div>

    @endif

@endsection
