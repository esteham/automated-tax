<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add security_pin to users table
        if (!Schema::hasColumn('users', 'security_pin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('security_pin', 4)->nullable()->after('phone');
            });
        }

        // Check if tax_profiles table exists before modifying it
        if (Schema::hasTable('tax_profiles')) {
            // Add the new columns first
            Schema::table('tax_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('tax_profiles', 'nid_number')) {
                    $table->string('nid_number')->nullable()->after('tin_number');
                }
                if (!Schema::hasColumn('tax_profiles', 'nid_issuing_country')) {
                    $table->string('nid_issuing_country')->nullable()->after('nid_number');
                }
                if (!Schema::hasColumn('tax_profiles', 'nid_issue_date')) {
                    $table->date('nid_issue_date')->nullable()->after('nid_issuing_country');
                }
                if (!Schema::hasColumn('tax_profiles', 'nid_expiry_date')) {
                    $table->date('nid_expiry_date')->nullable()->after('nid_issue_date');
                }
                if (!Schema::hasColumn('tax_profiles', 'tin_status')) {
                    $table->string('tin_status')->default('not_requested')->after('nid_expiry_date');
                }
            });

            // Then modify the tin_number column
            Schema::table('tax_profiles', function (Blueprint $table) {
                $table->string('tin_number')->nullable()->change();
                $table->dropUnique('tax_profiles_tin_number_unique');
            });
        }
    }

    public function down()
    {
        // Revert changes to users table
        if (Schema::hasColumn('users', 'security_pin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('security_pin');
            });
        }

        // Revert changes to tax_profiles table if it exists
        if (Schema::hasTable('tax_profiles')) {
            Schema::table('tax_profiles', function (Blueprint $table) {
                // Drop the added columns if they exist
                $columnsToDrop = ['nid_number', 'nid_issuing_country', 'nid_issue_date', 'nid_expiry_date', 'tin_status'];
                foreach ($columnsToDrop as $column) {
                    if (Schema::hasColumn('tax_profiles', $column)) {
                        $table->dropColumn($column);
                    }
                }
                
                // Restore the original tin_number constraints if the column exists
                if (Schema::hasColumn('tax_profiles', 'tin_number')) {
                    $table->string('tin_number')->nullable(false)->unique()->change();
                }
            });
        }
    }
};
