<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryExportController extends Controller
{
    // Export products to CSV
    public function productsCsv(): StreamedResponse
    {
        $products = Product::with('supplier')->get();

        return response()->streamDownload(function () use ($products) {
            $file = fopen('php://output', 'w');

            // CSV column headings
            fputcsv($file, [
                'Product Name',
                'SKU',
                'Supplier',
                'Category',
                'Quantity',
                'Reorder Level',
                'Unit Price',
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->product_name,
                    $product->sku,
                    $product->supplier->company_name ?? 'No Supplier',
                    $product->category,
                    $product->quantity,
                    $product->reorder_level,
                    $product->unit_price,
                ]);
            }

            fclose($file);
        }, 'product-inventory-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    // Export purchase orders to CSV
    public function purchaseOrdersCsv(): StreamedResponse
    {
        $orders = PurchaseOrder::with('supplier')->get();

        return response()->streamDownload(function () use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'PO Number',
                'Supplier',
                'Order Date',
                'Expected Delivery',
                'Total Amount',
                'Status',
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->po_number,
                    $order->supplier->company_name ?? 'No Supplier',
                    $order->order_date?->format('Y-m-d'),
                    $order->expected_delivery_date?->format('Y-m-d'),
                    $order->total_amount,
                    $order->status,
                ]);
            }

            fclose($file);
        }, 'purchase-order-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    // Export products to PDF
    public function productsPdf()
    {
        $products = Product::with('supplier')->get();

        $pdf = Pdf::loadView(
            'exports.products-pdf',
            compact('products')
        );

        return $pdf->download('product-inventory-report.pdf');
    }

    // Export purchase orders to PDF
    public function purchaseOrdersPdf()
    {
        $orders = PurchaseOrder::with('supplier')->get();

        $pdf = Pdf::loadView(
            'exports.purchase-orders-pdf',
            compact('orders')
        );

        return $pdf->download('purchase-order-report.pdf');
    }
}
