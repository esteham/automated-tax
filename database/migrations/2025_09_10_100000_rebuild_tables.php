<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Disable foreign key checks to avoid issues with table drops
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop all views first
        $this->dropAllViews();

        // Drop existing tables in reverse order of dependency
        $tables = [
            'tax_payments',
            'tax_exemptions',
            'tax_returns',
            'income_sources',
            'tax_profiles',
            'taxpayers',
            'personal_access_tokens',
            'password_reset_tokens',
            'sessions',
            'jobs',
            'cache',
            'cache_locks',
            'failed_jobs',
            'users',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Recreate users table with security_pin
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('security_pin', 4)->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('status')->default('active');
                $table->string('otp')->nullable();
                $table->timestamp('otp_expires_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Recreate tax_profiles table with all necessary fields
        if (!Schema::hasTable('tax_profiles')) {
            Schema::create('tax_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('tin_number')->nullable();
                $table->string('nid_number')->nullable();
                $table->string('nid_issuing_country')->nullable();
                $table->date('nid_issue_date')->nullable();
                $table->date('nid_expiry_date')->nullable();
                $table->string('country')->default('Bangladesh');
                $table->string('tax_office')->nullable();
                $table->date('registration_date')->nullable();
                $table->enum('taxpayer_type', ['individual', 'company'])->default('individual');
                $table->string('tax_identification_card')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
                $table->string('tin_status')->default('not_requested');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                // Indexes
                $table->index('tin_number');
                $table->index('nid_number');
                $table->index('status');
            });
        }

        // Recreate other necessary tables
        $this->createOtherTables();
    }

    public function down()
    {
        // This is a one-way migration - use a fresh migration to rollback
        throw new \RuntimeException('This migration cannot be rolled back. Use a fresh migration to reset the database.');
    }

    private function dropAllViews()
    {
        $views = DB::select("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW'");
        
        foreach ($views as $view) {
            $viewName = array_values((array)$view)[0];
            DB::statement("DROP VIEW IF EXISTS `{$viewName}`");
        }
    }

    private function createOtherTables()
    {
        // Create other necessary tables here
        if (!Schema::hasTable('tax_returns')) {
            Schema::create('tax_returns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tax_profile_id')->constrained('tax_profiles')->onDelete('cascade');
                $table->string('fiscal_year');
                $table->decimal('total_income', 15, 2);
                $table->decimal('taxable_income', 15, 2);
                $table->decimal('tax_paid', 15, 2);
                $table->enum('status', ['draft', 'submitted', 'processing', 'approved', 'rejected'])->default('draft');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('income_sources')) {
            Schema::create('income_sources', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tax_exemptions')) {
            Schema::create('tax_exemptions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('max_amount', 15, 2)->nullable();
                $table->timestamps();
            });
        }
    }
};
