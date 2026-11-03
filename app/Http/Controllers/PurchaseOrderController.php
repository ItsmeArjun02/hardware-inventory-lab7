<?php

namespace App\Http\Controllers;

use App\Services\DashboardStatisticsService;
use App\Mail\PurchaseOrderStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->latest()
            ->paginate(10);

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)
            ->orderBy('company_name')
            ->get();

        $products = Product::with('supplier')
            ->orderBy('product_name')
            ->get();

        return view('purchase-orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $totalAmount = collect($validated['products'])->sum(
                fn ($item) => $item['quantity'] * $item['unit_cost']
            );

            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'po_number' => 'PO-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->supplier_id != $validated['supplier_id']) {
                    throw new \Exception(
                        'All products must belong to the selected supplier.'
                    );
                }

                $purchaseOrder->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                ]);
            }
        });

        $this->clearDashboardCache();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'products');

        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('products');

        $suppliers = Supplier::where('is_active', true)
            ->orderBy('company_name')
            ->get();

        $products = Product::with('supplier')
            ->orderBy('product_name')
            ->get();

        return view('purchase-orders.edit', compact(
            'purchaseOrder',
            'suppliers',
            'products'
        ));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Only pending purchase orders can be edited.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            $totalAmount = collect($validated['products'])->sum(
                fn ($item) => $item['quantity'] * $item['unit_cost']
            );

            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
            ]);

            $syncData = [];

            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->supplier_id != $validated['supplier_id']) {
                    throw new \Exception(
                        'All products must belong to the selected supplier.'
                    );
                }

                $syncData[$product->id] = [
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                ];
            }

            $purchaseOrder->products()->sync($syncData);
        });

        $this->clearDashboardCache();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Only pending purchase orders can be deleted.');
        }

        $purchaseOrder->delete();

        $this->clearDashboardCache();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order deleted successfully.');
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('approve', $purchaseOrder);

        $purchaseOrder->update([
            'status' => 'approved',
        ]);

        $this->clearDashboardCache();

        Mail::to($purchaseOrder->supplier->email)
            ->send(new PurchaseOrderStatusMail(
                $purchaseOrder,
                'approved'
            ));

        return redirect()->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase Order approved successfully. Email notification prepared.');
    }

    public function reject(PurchaseOrder $purchaseOrder)
    {
        $this->authorize('reject', $purchaseOrder);

        $purchaseOrder->update([
            'status' => 'rejected',
        ]);

        $this->clearDashboardCache();

        Mail::to($purchaseOrder->supplier->email)
            ->send(new PurchaseOrderStatusMail(
                $purchaseOrder,
                'rejected'
            ));

        return redirect()->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase Order rejected successfully. Email notification prepared.');
    }

    private function clearDashboardCache(): void
    {
        app(DashboardStatisticsService::class)->clearCache();
    }
}
