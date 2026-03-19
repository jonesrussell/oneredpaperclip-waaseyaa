<?php

declare(strict_types=1);

namespace OneRedPaperclip\Migration;

use Waaseyaa\Database\DatabaseInterface;

/**
 * Migrates data from Laravel's MariaDB schema to Waaseyaa's entity storage.
 *
 * Reads from a source database (Laravel) and writes to a target database
 * (Waaseyaa) using direct SQL inserts. Handles column mapping, timestamp
 * conversion, and UUID generation.
 */
final class DataMigrator
{
    private bool $dryRun = false;

    /** @var array<string, int> */
    private array $counts = [];

    /** @var list<string> */
    private array $errors = [];

    public function __construct(
        private readonly DatabaseInterface $source,
        private readonly DatabaseInterface $target,
    ) {}

    public function setDryRun(bool $dryRun): static
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    public function isDryRun(): bool
    {
        return $this->dryRun;
    }

    /**
     * Migrate all entity types.
     *
     * @return array{counts: array<string, int>, errors: list<string>}
     */
    public function migrateAll(): array
    {
        $this->counts = [];
        $this->errors = [];

        foreach (ColumnMap::tableToEntityType() as $laravelTable => $entityTypeId) {
            $this->migrateTable($laravelTable, $entityTypeId);
        }

        return [
            'counts' => $this->counts,
            'errors' => $this->errors,
        ];
    }

    public function migrateTable(string $laravelTable, string $entityTypeId): void
    {
        $schema = $this->source->schema();
        if (!$schema->tableExists($laravelTable)) {
            $this->errors[] = "Source table '{$laravelTable}' does not exist.";

            return;
        }

        $targetSchema = $this->target->schema();
        if (!$targetSchema->tableExists($entityTypeId)) {
            $this->errors[] = "Target table '{$entityTypeId}' does not exist.";

            return;
        }

        $rows = $this->source->select($laravelTable)
            ->fields($laravelTable)
            ->execute();

        $count = 0;
        $skipColumns = ColumnMap::skipColumns()[$laravelTable] ?? [];
        $labelSource = ColumnMap::labelSources()[$entityTypeId] ?? '';

        foreach ($rows as $row) {
            $row = (array) $row;
            $waaseyaaRow = $this->transformRow($row, $entityTypeId, $skipColumns, $labelSource);

            if (!$this->dryRun) {
                $this->target->insert($entityTypeId)
                    ->fields(array_keys($waaseyaaRow))
                    ->values($waaseyaaRow)
                    ->execute();
            }

            $count++;
        }

        $this->counts[$entityTypeId] = $count;
    }

    /**
     * Transform a Laravel row to Waaseyaa format.
     *
     * @param array<string, mixed> $row
     * @param list<string> $skipColumns
     * @return array<string, mixed>
     */
    private function transformRow(array $row, string $entityTypeId, array $skipColumns, string $labelSource): array
    {
        $result = [];
        $extraData = [];
        $timestampColumns = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at', 'last_activity_at', 'confirmed_by_owner_at', 'confirmed_by_offerer_at', 'expires_at', 'read_at'];

        // Add Waaseyaa base columns.
        $result['uuid'] = $this->generateUuid();
        $result['bundle'] = '';
        $result['langcode'] = 'en';

        foreach ($row as $column => $value) {
            if (\in_array($column, $skipColumns, true)) {
                continue;
            }

            // Convert timestamps to ISO 8601.
            if (\in_array($column, $timestampColumns, true)) {
                $value = ColumnMap::convertTimestamp($value);
            }

            $result[$column] = $value;
        }

        // Set label column only if the entity type has a dedicated 'label' column
        // (i.e., label key maps to 'label', not to an existing field like 'name' or 'title').
        $labelKeyMappings = [
            'challenge' => 'title',
            'item' => 'title',
            'user' => 'name',
            'category' => 'name',
            'notification' => 'type',
            'offer' => 'label',
            'trade' => 'label',
            'comment' => 'label',
            'follow' => 'label',
            'media' => 'label',
        ];

        $labelColumnName = $labelKeyMappings[$entityTypeId] ?? 'label';
        if ($labelColumnName === 'label') {
            $result['label'] = ($labelSource !== '' && isset($row[$labelSource]))
                ? (string) $row[$labelSource]
                : '';
        }

        // Set _data for any extra fields that don't have columns.
        $result['_data'] = json_encode($extraData);

        return $result;
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
        );
    }
}
