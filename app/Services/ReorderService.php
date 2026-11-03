<?php

namespace App\Services;

use App\Models\Product;

class ReorderService
{
    public function calculateReorderPoint(Product $product): float
    {
        $leadTime = $product->supplier->lead_time ?? 0;

        return ($product->average_daily_usage * $leadTime)
            + $product->safety_stock;
    }

    public function needsReordering(Product $product): bool
    {
        return $product->quantity <= $this->calculateReorderPoint($product);
    }
}