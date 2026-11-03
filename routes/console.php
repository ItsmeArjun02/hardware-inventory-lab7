
<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('inventory:generate-purchase-orders')
    ->daily();
