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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_profile_id')->constrained('partner_profiles')->cascadeOnDelete();
            $table->foreignId('profession_id')->constrained('professions')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('price_type', ['fixed', 'starting_from', 'survey'])->default('fixed');
            $table->decimal('base_price', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
