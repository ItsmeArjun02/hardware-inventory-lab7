
<?php
use App\Http\Controllers\InventoryExportController;
use App\Http\Controllers\SupplierPerformanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderGenerationController;

Route::get('/', function () {
    return redirect()->route('suppliers.index');
});

// Login and Logout
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

    

// Supplier Management
Route::resource('suppliers', SupplierController::class);

// Product Management
Route::resource('products', ProductController::class);

// Purchase Order Management
Route::resource('purchase-orders', PurchaseOrderController::class);

// Purchase Order Approval and Rejection

// Supplier Performance Tracking
Route::get(
    '/supplier-performance',
    [SupplierPerformanceController::class, 'index']
)->middleware('auth')->name('suppliers.performance');
// Dashboard
Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');
Route::post(
    '/purchase-orders/{purchaseOrder}/approve',
    [PurchaseOrderController::class, 'approve']
)->middleware('auth')->name('purchase-orders.approve');

Route::post(
    '/purchase-orders/{purchaseOrder}/reject',
    [PurchaseOrderController::class, 'reject']
)->middleware('auth')->name('purchase-orders.reject');

// Automatic Purchase Order Generation
Route::post(
    '/purchase-orders/generate',
    [PurchaseOrderGenerationController::class, 'generate']
)->name('purchase-orders.generate');
// Inventory and Purchase Order Exports
Route::middleware('auth')->group(function () {

    Route::get('/exports/products/csv',
        [InventoryExportController::class, 'productsCsv']
    )->name('exports.products.csv');

    Route::get('/exports/products/pdf',
        [InventoryExportController::class, 'productsPdf']
    )->name('exports.products.pdf');

    Route::get('/exports/purchase-orders/csv',
        [InventoryExportController::class, 'purchaseOrdersCsv']
    )->name('exports.purchase-orders.csv');

    Route::get('/exports/purchase-orders/pdf',
        [InventoryExportController::class, 'purchaseOrdersPdf']
    )->name('exports.purchase-orders.pdf');

});
