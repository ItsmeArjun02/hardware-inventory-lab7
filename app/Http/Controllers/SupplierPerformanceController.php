<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

class SupplierPerformanceController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with([
            'products',
            'purchaseOrders'
        ])->get();

        $performance = $suppliers->map(function ($supplier) {
            $orders = $supplier->purchaseOrders;

            return [
                'supplier' => $supplier,

                'total_products' => $supplier->products->count(),

                'total_orders' => $orders->count(),

                'approved_orders' => $orders->where(
                    'status',
                    'approved'
                )->count(),

                'pending_orders' => $orders->where(
                    'status',
                    'pending'
                )->count(),

                'rejected_orders' => $orders->where(
                    'status',
                    'rejected'
                )->count(),

                'approved_amount' => $orders
                    ->where('status', 'approved')
                    ->sum('total_amount'),
            ];
        });

        return view(
            'suppliers.performance',
            compact('performance')
        );
    }
}
