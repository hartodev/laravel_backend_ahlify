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
        Schema::create('partner_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('profession_id')->constrained('professions')->cascadeOnDelete();

            $table->text('bio')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_verified')->default(false);

            $table->enum('availability_status', ['online', 'offline', 'busy'])->default('offline');
            $table->boolean('auto_offline_enabled')->default(false);
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->timestamp('last_seen_at')->nullable();

            $table->decimal('average_rating', 3, 2)->default(0);
            $table->unsignedInteger('total_jobs')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_profiles');
    }
};
