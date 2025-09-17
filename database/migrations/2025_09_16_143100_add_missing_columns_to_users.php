<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check and add country if it doesn't exist
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('phone');
            }
            
            // Check and add security_pin if it doesn't exist
            if (!Schema::hasColumn('users', 'security_pin')) {
                $table->string('security_pin', 60)->nullable()->after('country');
            }
            
            // Check and add otp if it doesn't exist
            if (!Schema::hasColumn('users', 'otp')) {
                $table->string('otp', 6)->nullable()->after('security_pin');
            }
            
            // Check and add otp_expires_at if it doesn't exist
            if (!Schema::hasColumn('users', 'otp_expires_at')) {
                $table->timestamp('otp_expires_at')->nullable()->after('otp');
            }
            
            // Add softDeletes if it doesn't exist
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a safe down migration that won't drop columns if they're being used
        // You can manually remove columns if needed
    }
};
