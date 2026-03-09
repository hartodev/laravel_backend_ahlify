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
        Schema::create('payment_virtual_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();

            $table->string('partner_service_id', 20);
            $table->string('customer_no', 30);
            $table->string('virtual_account_no', 50)->unique();
            $table->string('virtual_account_name');
            $table->string('virtual_account_email')->nullable();
            $table->string('virtual_account_phone', 20)->nullable();
            $table->string('trx_id')->unique();

            $table->string('payment_request_id')->nullable();
            $table->string('reference_no')->nullable();

            $table->enum('payment_type', ['close', 'open'])->default('close');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->string('currency', 3)->default('IDR');
            $table->timestamp('expired_date');

            $table->json('raw_create_request')->nullable();
            $table->json('raw_create_response')->nullable();
            $table->json('raw_callback_payload')->nullable();

            $table->enum('status', ['created', 'pending', 'paid', 'expired', 'failed'])->default('created');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_virtual_accounts');
    }
};
