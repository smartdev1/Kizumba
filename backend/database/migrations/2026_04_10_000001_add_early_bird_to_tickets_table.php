<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('early_bird_price')->nullable()->after('price');
            $table->timestamp('early_bird_starts_at')->nullable()->after('early_bird_price');
            $table->timestamp('early_bird_ends_at')->nullable()->after('early_bird_starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['early_bird_price', 'early_bird_starts_at', 'early_bird_ends_at']);
        });
    }
};
