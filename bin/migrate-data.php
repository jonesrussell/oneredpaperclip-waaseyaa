<?php

declare(strict_types=1);

/**
 * Data migration script: Laravel SQLite → Waaseyaa SQLite
 *
 * Usage:
 *   php bin/migrate-data.php                    # Dry run
 *   php bin/migrate-data.php --execute          # Execute migration
 *   php bin/migrate-data.php --source=path.db   # Custom source path
 */

require_once __DIR__ . '/../vendor/autoload.php';

use OneRedPaperclip\Migration\DataMigrator;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use Waaseyaa\Database\DBALDatabase;

$args = array_slice($argv, 1);
$execute = in_array('--execute', $args, true);
$sourcePath = null;

foreach ($args as $arg) {
    if (str_starts_with($arg, '--source=')) {
        $sourcePath = substr($arg, 9);
    }
}

$sourcePath ??= __DIR__ . '/../backups/laravel-backup-' . date('Ymd') . '.sqlite';
$targetPath = __DIR__ . '/../database/database.sqlite';

if (!file_exists($sourcePath)) {
    echo "Source database not found: {$sourcePath}\n";
    exit(1);
}

echo "=== One Red Paperclip Data Migration ===\n";
echo "Source: {$sourcePath}\n";
echo "Target: {$targetPath}\n";
echo "Mode: " . ($execute ? "EXECUTE" : "DRY RUN") . "\n\n";

// Open source (Laravel schema).
$source = DBALDatabase::createSqlite($sourcePath);

// Create target database and schema.
$target = DBALDatabase::createSqlite($targetPath);

$provider = new TradeUpServiceProvider();
$provider->register();

echo "Installing Waaseyaa schema (10 tables)...\n";
$installer = new SchemaInstaller($target, $provider->getEntityTypes());
$installer->install();
echo "Schema ready.\n\n";

// Run migration.
$migrator = new DataMigrator($source, $target);
$migrator->setDryRun(!$execute);

// Migrate tables that exist in the source.
$tables = [
    'categories' => 'category',
    'users' => 'user',
    'items' => 'item',
    'challenges' => 'challenge',
];

$totalCount = 0;
$totalErrors = [];

foreach ($tables as $laravelTable => $entityTypeId) {
    echo "Migrating {$laravelTable} → {$entityTypeId}...";

    $migrator->migrateTable($laravelTable, $entityTypeId);

    // Count what was migrated by querying target.
    if ($execute) {
        $rows = $target->select($entityTypeId)->fields($entityTypeId)->execute();
        $count = count(iterator_to_array($rows));
        echo " {$count} rows\n";
        $totalCount += $count;
    } else {
        $sourceRows = $source->select($laravelTable)->fields($laravelTable)->execute();
        $count = count(iterator_to_array($sourceRows));
        echo " {$count} rows (dry run)\n";
        $totalCount += $count;
    }
}

echo "\n=== Migration " . ($execute ? "Complete" : "Dry Run Complete") . " ===\n";
echo "Total rows: {$totalCount}\n";

if (!$execute) {
    echo "\nRun with --execute to perform the actual migration.\n";
}
