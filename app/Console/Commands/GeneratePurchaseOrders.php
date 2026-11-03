<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PurchaseOrderGenerationService;

class GeneratePurchaseOrders extends Command
{
    protected $signature = 'inventory:generate-purchase-orders';

    protected $description = 'Automatically generate purchase orders for products that need replenishment';

    public function handle(
        PurchaseOrderGenerationService $generationService
    ): int {
        $createdOrders = $generationService->generate();

        if (count($createdOrders) === 0) {
            $this->info('No products currently need reordering.');

            return self::SUCCESS;
        }

        $this->info(
            count($createdOrders) . ' automatic Purchase Order(s) generated successfully.'
        );

        return self::SUCCESS;
    }
}
