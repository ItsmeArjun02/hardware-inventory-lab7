<?php

namespace App\Http\Controllers;

use App\Services\DashboardStatisticsService;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('supplier')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)
            ->orderBy('company_name')
            ->get();

        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'average_daily_usage' => 'required|numeric|min:0',
            'safety_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        $this->clearDashboardCache();

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        $product->load('supplier');

        $reorderService = new \App\Services\ReorderService();

        $reorderPoint = $reorderService->calculateReorderPoint($product);
        $needsReordering = $reorderService->needsReordering($product);

        return view('products.show', compact(
            'product',
            'reorderPoint',
            'needsReordering'
        ));
    }

    public function edit(Product $product)
    {
        $suppliers = Supplier::where('is_active', true)
            ->orderBy('company_name')
            ->get();

        return view('products.edit', compact('product', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'average_daily_usage' => 'required|numeric|min:0',
            'safety_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        $this->clearDashboardCache();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $this->clearDashboardCache();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function clearDashboardCache(): void
    {
        app(DashboardStatisticsService::class)->clearCache();
    }
}
