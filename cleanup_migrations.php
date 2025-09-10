<?php

$migrationsDir = __DIR__ . '/database/migrations/';

// List of files to KEEP (do not delete these)
$keepFiles = [
    '0001_01_01_000000_create_users_table.php',
    '0001_01_01_000001_create_cache_table.php',
    '0001_01_01_000002_create_jobs_table.php',
    '2025_09_03_160314_create_permission_tables.php',
    '2025_09_03_171137_create_taxpayers_table.php',
    '2025_09_07_103500_create_tax_returns_table.php',
    '2025_09_07_103501_create_income_sources_table.php',
    '2025_09_07_103502_create_tax_exemptions_table.php',
    '2025_09_07_103503_create_tax_payments_table.php',
    '2025_09_07_103600_create_tax_tables.php',
    '2025_09_10_040134_add_tin_registration_fields_to_users_table.php' // Our final migration
];

// Get all PHP files in migrations directory
$files = glob($migrationsDir . '*.php');

$deleted = 0;
foreach ($files as $file) {
    $filename = basename($file);
    if (!in_array($filename, $keepFiles)) {
        if (unlink($file)) {
            echo "Deleted: $filename\n";
            $deleted++;
        } else {
            echo "Failed to delete: $filename\n";
        }
    }
}

echo "\nCleanup complete. Deleted $deleted migration files.\n";
