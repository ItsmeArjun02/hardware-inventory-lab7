<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('company_name');
            $table->string('contact_person');
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->string('payment_terms')->nullable();
            $table->unsignedInteger('lead_time')->default(7);
            $table->decimal('minimum_order_amount', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropUnique(['email']);

            $table->dropColumn([
                'company_name',
                'contact_person',
                'email',
                'phone',
                'address',
                'payment_terms',
                'lead_time',
                'minimum_order_amount',
                'is_active',
            ]);
        });
    }
};