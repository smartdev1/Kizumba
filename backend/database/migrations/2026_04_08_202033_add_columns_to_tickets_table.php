<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('slug')->unique()->after('id');
            $table->string('name')->after('slug');
            $table->text('description')->nullable()->after('name');
            $table->string('category')->after('description');
            $table->unsignedBigInteger('price')->after('category');
            $table->string('currency', 10)->default('FCFA')->after('price');
            $table->json('includes')->nullable()->after('currency');
            $table->unsignedInteger('stock')->default(0)->after('includes');
            $table->unsignedInteger('sold')->default(0)->after('stock');
            $table->boolean('is_active')->default(true)->after('sold');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'name', 'description', 'category',
                'price', 'currency', 'includes', 'stock', 'sold', 'is_active',
            ]);
        });
    }
};
