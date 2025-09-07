<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_return_id')->constrained()->cascadeOnDelete();
            $table->string('source_type'); // salary, business, freelance, rent, interest, etc.
            $table->string('source_name');
            $table->decimal('amount', 15, 2);
            $table->json('details')->nullable(); // For storing additional source-specific details
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_sources');
    }
};
