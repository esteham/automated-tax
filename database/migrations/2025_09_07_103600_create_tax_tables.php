<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tax exemption types table
        Schema::create('tax_exemption_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('max_amount', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tax rates table
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('filing_type'); // individual, business, freelancer
            $table->decimal('min_income', 15, 2);
            $table->decimal('max_income', 15, 2)->nullable();
            $table->decimal('rate', 5, 2); // Tax rate in percentage
            $table->text('description')->nullable();
            $table->timestamps();

            // Add index for faster lookups
            $table->index(['filing_type', 'min_income', 'max_income']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
        Schema::dropIfExists('tax_exemption_types');
    }
};
