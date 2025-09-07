<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxpayer_id')->constrained()->cascadeOnDelete();
            $table->string('filing_year');
            $table->enum('filing_type', ['individual', 'business', 'freelancer']);
            
            // Status tracking
            $table->enum('status', ['draft', 'submitted', 'processing', 'approved', 'rejected'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            
            // Income details
            $table->decimal('total_income', 15, 2)->default(0);
            $table->decimal('taxable_income', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            
            // Payment details
            $table->string('payment_status')->default('unpaid');
            $table->string('challan_number')->nullable();
            $table->timestamp('payment_date')->nullable();
            
            // Audit fields
            $table->text('notes')->nullable();
            $table->json('calculation_details')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_returns');
    }
};
