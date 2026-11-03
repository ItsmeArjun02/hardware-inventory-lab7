<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'supplier_id',
        'product_name',
        'sku',
        'description',
        'category',
        'quantity',
        'reorder_level',
        'average_daily_usage',
        'safety_stock',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'reorder_level' => 'integer',
            'average_daily_usage' => 'decimal:2',
            'safety_stock' => 'integer',
            'unit_price' => 'decimal:2',
        ];
    }

public function supplier(): BelongsTo
{
    return $this->belongsTo(Supplier::class)->withTrashed();
}
    public function purchaseOrders(): BelongsToMany
    {
        return $this->belongsToMany(PurchaseOrder::class)
            ->withPivot('quantity', 'unit_cost')
            ->withTimestamps();
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    public function calculateReorderPoint(): float
    {
        return ($this->average_daily_usage * $this->supplier->lead_time)
            + $this->safety_stock;
    }

    public function needsReordering(): bool
    {
        return $this->quantity <= $this->calculateReorderPoint();
    }
}