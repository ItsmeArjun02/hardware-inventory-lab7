<?php

namespace App\Http\Controllers;

use App\Services\DashboardStatisticsService;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
            'payment_terms' => 'nullable|string|max:255',
            'lead_time' => 'required|integer|min:1',
            'minimum_order_amount' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        Supplier::create($validated);

        $this->clearDashboardCache();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier added successfully.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
            'payment_terms' => 'nullable|string|max:255',
            'lead_time' => 'required|integer|min:1',
            'minimum_order_amount' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $supplier->update($validated);

        $this->clearDashboardCache();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        $this->clearDashboardCache();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    private function clearDashboardCache(): void
    {
        app(DashboardStatisticsService::class)->clearCache();
    }
}
