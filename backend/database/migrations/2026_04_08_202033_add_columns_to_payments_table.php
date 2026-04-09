<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('tx_ref')->unique()->after('id');
            $table->string('paydunya_token')->nullable()->after('tx_ref');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending')->after('paydunya_token');
            $table->unsignedBigInteger('amount')->after('status');
            $table->string('currency', 10)->default('FCFA')->after('amount');
            $table->string('customer_name')->after('currency');
            $table->string('customer_email')->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->json('cart_items')->after('customer_phone');
            $table->json('paydunya_response')->nullable()->after('cart_items');
            $table->timestamp('paid_at')->nullable()->after('paydunya_response');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'tx_ref', 'paydunya_token', 'status', 'amount', 'currency',
                'customer_name', 'customer_email', 'customer_phone',
                'cart_items', 'paydunya_response', 'paid_at',
            ]);
        });
    }
};
