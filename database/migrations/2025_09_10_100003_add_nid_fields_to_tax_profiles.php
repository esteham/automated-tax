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
        Schema::table('tax_profiles', function (Blueprint $table) {
            $table->string('nid_front_image')->nullable()->after('nid_expiry_date');
            $table->string('nid_back_image')->nullable()->after('nid_front_image');
            $table->timestamp('tin_requested_at')->nullable()->after('tin_status');
            $table->timestamp('tin_approved_at')->nullable()->after('tin_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'nid_front_image',
                'nid_back_image',
                'tin_requested_at',
                'tin_approved_at'
            ]);
        });
    }
};
