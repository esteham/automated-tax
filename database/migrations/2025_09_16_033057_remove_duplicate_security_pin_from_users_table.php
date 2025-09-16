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
        // First, check if the column exists
        if (Schema::hasColumn('users', 'security_pin')) {
            Schema::table('users', function (Blueprint $table) {
                // Drop the column if it exists
                $table->dropColumn('security_pin');
            });
            
            // Also remove the column from the migrations table to prevent future issues
            \DB::table('migrations')
                ->where('migration', 'like', '%security_pin%')
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is intentionally left empty as we don't want to recreate the column
        // since it was causing issues
    }
};
