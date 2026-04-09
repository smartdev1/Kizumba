<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('issued_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique(); // identifiant unique lisible (QR code)
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained('tickets');
            // Snapshot du ticket au moment de l'achat
            $table->string('ticket_name');
            $table->unsignedBigInteger('price_paid');
            $table->string('currency', 10)->default('FCFA');
            // Bénéficiaire
            $table->string('holder_name');
            $table->string('holder_email');
            $table->string('holder_phone')->nullable();
            // État
            $table->enum('status', ['active', 'used', 'cancelled'])->default('active');
            $table->boolean('email_sent')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issued_tickets');
    }
};
