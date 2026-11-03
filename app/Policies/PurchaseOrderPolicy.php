<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;

class PurchaseOrderPolicy
{
    public function approve(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return in_array($user->role, [
            'Administrator',
            'School Principal',
        ]) && $purchaseOrder->status === 'pending';
    }

    public function reject(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return in_array($user->role, [
            'Administrator',
            'School Principal',
        ]) && $purchaseOrder->status === 'pending';
    }
}
