<?php

namespace App\Http\Controllers;

use App\Services\PurchaseOrderGenerationService;
use Illuminate\Http\RedirectResponse;

class PurchaseOrderGenerationController extends Controller
{
    public function generate(
        PurchaseOrderGenerationService $generationService
    ): RedirectResponse {
        $createdOrders = $generationService->generate();

        if (count($createdOrders) === 0) {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'No products currently need reordering.');
        }

        return redirect()->route('purchase-orders.index')
            ->with(
                'success',
                count($createdOrders) . ' automatic Purchase Order(s) generated successfully.'
            );
    }
}