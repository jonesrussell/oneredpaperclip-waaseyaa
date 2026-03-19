<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Migration;

use OneRedPaperclip\Migration\DataMigrator;
use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Waaseyaa\Database\DBALDatabase;

#[CoversClass(DataMigrator::class)]
final class DataMigratorTest extends TestCase
{
    private DBALDatabase $source;
    private DBALDatabase $target;

    protected function setUp(): void
    {
        // Source: simulates Laravel's schema (minimal).
        $this->source = DBALDatabase::createSqlite();

        // Target: Waaseyaa schema via SchemaInstaller.
        $this->target = DBALDatabase::createSqlite();
        $provider = new TradeUpServiceProvider();
        $provider->register();
        (new SchemaInstaller($this->target, $provider->getEntityTypes()))->install();

        // Create simplified Laravel source tables.
        $this->createLaravelSourceTables();
    }

    private function createLaravelSourceTables(): void
    {
        $schema = $this->source->schema();

        $schema->createTable('categories', [
            'fields' => [
                'id' => ['type' => 'serial', 'not null' => true],
                'name' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'slug' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'created_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
                'updated_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
            ],
            'primary key' => ['id'],
        ]);

        $schema->createTable('challenges', [
            'fields' => [
                'id' => ['type' => 'serial', 'not null' => true],
                'user_id' => ['type' => 'int', 'not null' => true],
                'category_id' => ['type' => 'int', 'not null' => false],
                'status' => ['type' => 'varchar', 'length' => 255, 'not null' => true, 'default' => 'active'],
                'visibility' => ['type' => 'varchar', 'length' => 255, 'not null' => true, 'default' => 'public'],
                'title' => ['type' => 'varchar', 'length' => 255, 'not null' => false],
                'slug' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'story' => ['type' => 'text', 'not null' => false],
                'current_item_id' => ['type' => 'int', 'not null' => false],
                'goal_item_id' => ['type' => 'int', 'not null' => false],
                'trades_count' => ['type' => 'int', 'not null' => false, 'default' => 0],
                'created_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
                'updated_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
                'deleted_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
            ],
            'primary key' => ['id'],
        ]);

        $schema->createTable('items', [
            'fields' => [
                'id' => ['type' => 'serial', 'not null' => true],
                'itemable_type' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'itemable_id' => ['type' => 'int', 'not null' => true],
                'role' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'title' => ['type' => 'varchar', 'length' => 255, 'not null' => true],
                'description' => ['type' => 'text', 'not null' => false],
                'created_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
                'updated_at' => ['type' => 'varchar', 'length' => 32, 'not null' => false],
            ],
            'primary key' => ['id'],
        ]);
    }

    #[Test]
    public function migratesCategoriesTable(): void
    {
        $this->source->insert('categories')
            ->fields(['name', 'slug', 'created_at', 'updated_at'])
            ->values([
                'name' => 'Electronics',
                'slug' => 'electronics',
                'created_at' => '2026-03-01 10:00:00',
                'updated_at' => '2026-03-01 10:00:00',
            ])
            ->execute();

        $migrator = new DataMigrator($this->source, $this->target);
        $migrator->migrateTable('categories', 'category');

        // Verify data in target.
        $rows = $this->target->select('category')
            ->fields('category')
            ->execute();
        $row = (array) iterator_to_array($rows)[0];

        $this->assertSame('Electronics', $row['name']);
        $this->assertSame('electronics', $row['slug']);
        $this->assertSame('2026-03-01T10:00:00Z', $row['created_at']);
        $this->assertNotEmpty($row['uuid']);
        $this->assertSame('en', $row['langcode']);
    }

    #[Test]
    public function migratesChallengesWithTimestampConversion(): void
    {
        $this->source->insert('challenges')
            ->fields(['user_id', 'status', 'visibility', 'title', 'slug', 'story', 'trades_count', 'created_at', 'updated_at'])
            ->values([
                'user_id' => 1,
                'status' => 'active',
                'visibility' => 'public',
                'title' => 'Red Paperclip',
                'slug' => 'red-paperclip',
                'story' => 'Trade up!',
                'trades_count' => 3,
                'created_at' => '2026-03-19 12:00:00',
                'updated_at' => '2026-03-19 15:00:00',
            ])
            ->execute();

        $migrator = new DataMigrator($this->source, $this->target);
        $migrator->migrateTable('challenges', 'challenge');

        $rows = $this->target->select('challenge')
            ->fields('challenge')
            ->execute();
        $row = (array) iterator_to_array($rows)[0];

        $this->assertSame('Red Paperclip', $row['title']);
        $this->assertSame('active', $row['status']);
        $this->assertSame('Trade up!', $row['story']);
        $this->assertSame('2026-03-19T12:00:00Z', $row['created_at']);
        $this->assertSame('2026-03-19T15:00:00Z', $row['updated_at']);
        // Challenge uses 'title' as label key — no separate 'label' column.
        $this->assertSame('Red Paperclip', $row['title']);
    }

    #[Test]
    public function migratesItemsTable(): void
    {
        $this->source->insert('items')
            ->fields(['itemable_type', 'itemable_id', 'role', 'title', 'description', 'created_at'])
            ->values([
                'itemable_type' => 'challenge',
                'itemable_id' => 1,
                'role' => 'start',
                'title' => 'Paperclip',
                'description' => 'A red paperclip',
                'created_at' => '2026-03-19 10:00:00',
            ])
            ->execute();

        $migrator = new DataMigrator($this->source, $this->target);
        $migrator->migrateTable('items', 'item');

        $rows = $this->target->select('item')
            ->fields('item')
            ->execute();
        $row = (array) iterator_to_array($rows)[0];

        $this->assertSame('Paperclip', $row['title']);
        $this->assertSame('start', $row['role']);
        // Item uses 'title' as label key — no separate 'label' column.
        $this->assertSame('Paperclip', $row['title']);
    }

    #[Test]
    public function dryRunDoesNotWriteData(): void
    {
        $this->source->insert('categories')
            ->fields(['name', 'slug'])
            ->values(['name' => 'Test', 'slug' => 'test'])
            ->execute();

        $migrator = new DataMigrator($this->source, $this->target);
        $migrator->setDryRun(true);
        $migrator->migrateTable('categories', 'category');

        $this->assertTrue($migrator->isDryRun());

        // Target should be empty.
        $rows = $this->target->select('category')
            ->fields('category')
            ->execute();
        $this->assertCount(0, iterator_to_array($rows));
    }

    #[Test]
    public function reportsErrorForMissingSourceTable(): void
    {
        $migrator = new DataMigrator($this->source, $this->target);
        $result = $migrator->migrateAll();

        // Source doesn't have users, offers, trades, etc.
        $this->assertNotEmpty($result['errors']);
    }

    #[Test]
    public function migratesMultipleRows(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->source->insert('categories')
                ->fields(['name', 'slug'])
                ->values(['name' => "Category {$i}", 'slug' => "category-{$i}"])
                ->execute();
        }

        $migrator = new DataMigrator($this->source, $this->target);
        $migrator->migrateTable('categories', 'category');

        $rows = $this->target->select('category')->fields('category')->execute();
        $this->assertCount(5, iterator_to_array($rows));
    }
}
