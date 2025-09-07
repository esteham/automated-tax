<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_return_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method'); // bKash, Nagad, Bank, etc.
            $table->string('transaction_id');
            $table->decimal('amount', 15, 2);
            $table->string('challan_number')->unique();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->json('payment_details')->nullable(); // Store payment gateway response
            $table->string('receipt_path')->nullable(); // Path to payment receipt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_payments');
    }
};
