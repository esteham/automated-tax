<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_exemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_return_id')->constrained()->cascadeOnDelete();
            $table->string('exemption_type'); // life_insurance, provident_fund, govt_bonds, donations, etc.
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->json('details')->nullable(); // For storing additional exemption details
            $table->string('document_path')->nullable(); // Path to uploaded document
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_exemptions');
    }
};
