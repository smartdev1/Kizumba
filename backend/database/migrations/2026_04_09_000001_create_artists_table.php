<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['professeur', 'dj']);
            $table->string('specialty')->nullable();
            $table->string('country')->nullable();          // ex: "France"
            $table->string('country_flag')->nullable();     // ex: "🇫🇷"
            $table->text('bio')->nullable();
            $table->string('instagram')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
