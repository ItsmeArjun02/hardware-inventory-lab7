<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'supplier_id',
        'po_number',
        'order_date',
        'expected_delivery_date',
        'total_amount',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'date',
            'expected_delivery_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

 public function supplier(): BelongsTo
{
    return $this->belongsTo(Supplier::class)->withTrashed();
}

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit_cost')
            ->withTimestamps();
    }
}