<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderGenerationService
{
    public function __construct(
        protected ReorderService $reorderService
    ) {
    }

    public function generate(): array
    {
        $products = Product::with('supplier')
            ->whereHas('supplier', function ($query) {
                $query->where('is_active', true)
                    ->whereNull('deleted_at');
            })
            ->whereDoesntHave('purchaseOrders', function ($query) {
                $query->where('status', 'pending');
            })
            ->get();

        $productsToReorder = $products->filter(function ($product) {
            return $this->reorderService->needsReordering($product);
        });

        $groupedProducts = $productsToReorder->groupBy('supplier_id');

        $createdOrders = [];

        foreach ($groupedProducts as $supplierId => $supplierProducts) {
            $purchaseOrder = DB::transaction(function () use (
                $supplierId,
                $supplierProducts
            ) {
                $supplier = $supplierProducts->first()->supplier;

                if (!$supplier || !$supplier->is_active) {
                    return null;
                }

                $totalAmount = 0;

                foreach ($supplierProducts as $product) {
                    $reorderPoint = $this->reorderService
                        ->calculateReorderPoint($product);

                    $quantityToOrder = max(
                        1,
                        (int) ceil($reorderPoint - $product->quantity)
                    );

                    $totalAmount += $quantityToOrder * $product->unit_price;
                }

                $purchaseOrder = PurchaseOrder::create([
                    'supplier_id' => $supplierId,
                    'po_number' => 'PO-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                    'order_date' => now()->toDateString(),
                    'expected_delivery_date' => now()
                        ->addDays($supplier->lead_time)
                        ->toDateString(),
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                    'notes' => 'Automatically generated due to low inventory stock.',
                ]);

                foreach ($supplierProducts as $product) {
                    $reorderPoint = $this->reorderService
                        ->calculateReorderPoint($product);

                    $quantityToOrder = max(
                        1,
                        (int) ceil($reorderPoint - $product->quantity)
                    );

                    $purchaseOrder->products()->attach($product->id, [
                        'quantity' => $quantityToOrder,
                        'unit_cost' => $product->unit_price,
                    ]);
                }

                return $purchaseOrder;
            });

            if ($purchaseOrder !== null) {
                $createdOrders[] = $purchaseOrder;
            }
        }

        return $createdOrders;
    }
}
