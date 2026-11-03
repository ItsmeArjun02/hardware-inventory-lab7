<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Cache;

class DashboardStatisticsService
{
    public function getStatistics(): array
    {
        return Cache::remember(
            'dashboard_statistics',
            now()->addSeconds(60),
            function () {
                $products = Product::with('supplier')->get();

                $reorderService = app(ReorderService::class);

                $productsToReorder = $products->filter(
                    function ($product) use ($reorderService) {
                        return $reorderService->needsReordering($product);
                    }
                )->count();

                return [
                    'totalSuppliers' => Supplier::count(),

                    'totalProducts' => $products->count(),

                    'pendingOrders' => PurchaseOrder::where(
                        'status',
                        'pending'
                    )->count(),

                    'productsToReorder' => $productsToReorder,
                ];
            }
        );
    }

    public function clearCache(): void
    {
        Cache::forget('dashboard_statistics');
    }
}
