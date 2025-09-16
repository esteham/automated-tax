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
        if (!Schema::hasTable('taxpayers')) {
            Schema::create('taxpayers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('tin_number', 50)->unique();
                $table->enum('taxpayer_type', ['individual','business'])->default('individual');
                $table->string('business_name')->nullable();
                $table->string('business_type')->nullable();
                $table->string('nid', 50)->nullable();
                $table->text('address')->nullable();
                $table->json('bank_details')->nullable();
                $table->timestamps();

                // Foreign key constraint
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxpayers');
    }
};
