<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            // Pour 'percentage' : valeur entre 1 et 100 (ex: 20 = 20%)
            // Pour 'fixed' : montant en FCFA (ex: 10000)
            $table->unsignedInteger('value');
            $table->unsignedInteger('max_uses')->nullable(); // null = illimité
            $table->unsignedInteger('uses_count')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            // Slugs de tickets auxquels le code est applicable — null = tous
            $table->json('applicable_slugs')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
