<?php

declare(strict_types=1);

namespace OneRedPaperclip\Schema;

use Waaseyaa\Database\DatabaseInterface;
use Waaseyaa\Entity\EntityTypeInterface;
use Waaseyaa\EntityStorage\SqlSchemaHandler;

final class SchemaInstaller
{
    /**
     * @param DatabaseInterface $database
     * @param list<EntityTypeInterface> $entityTypes
     */
    public function __construct(
        private readonly DatabaseInterface $database,
        private readonly array $entityTypes,
    ) {}

    public function install(): void
    {
        foreach ($this->entityTypes as $entityType) {
            $handler = new SqlSchemaHandler($entityType, $this->database);
            $handler->ensureTable();

            $fieldSchemas = $this->buildFieldSchemas($entityType);
            if ($fieldSchemas !== []) {
                $handler->addFieldColumns($fieldSchemas);
            }
        }

        $this->addConstraints();
    }

    /**
     * Convert entity type field definitions to SQL column specs.
     *
     * Skips fields that are already created as base columns by ensureTable()
     * (id, uuid, bundle, label, langcode).
     *
     * @return array<string, array<string, mixed>>
     */
    private function buildFieldSchemas(EntityTypeInterface $entityType): array
    {
        $fieldDefinitions = $entityType->getFieldDefinitions();
        $keys = $entityType->getKeys();
        $baseColumns = array_unique(array_merge(
            array_values($keys),
            ['_data', 'bundle', 'langcode'],
        ));

        $schemas = [];

        foreach ($fieldDefinitions as $fieldName => $def) {
            if (in_array($fieldName, $baseColumns, true)) {
                continue;
            }

            $schemas[$fieldName] = $this->fieldDefToColumnSpec($def);
        }

        return $schemas;
    }

    /**
     * Map a field definition to a SQL column specification.
     *
     * @param array<string, mixed> $def
     * @return array<string, mixed>
     */
    private function fieldDefToColumnSpec(array $def): array
    {
        $type = $def['type'] ?? 'string';

        return match ($type) {
            'string' => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => ($def['required'] ?? false),
                'default' => '',
            ],
            'text' => [
                'type' => 'text',
                'not null' => false,
            ],
            'integer', 'int' => [
                'type' => 'int',
                'not null' => ($def['required'] ?? false),
                'default' => 0,
            ],
            'entity_reference' => [
                'type' => 'int',
                'not null' => false,
                'unsigned' => true,
            ],
            'timestamp' => [
                'type' => 'varchar',
                'length' => 32,
                'not null' => false,
            ],
            'map' => [
                'type' => 'text',
                'not null' => false,
            ],
            default => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => false,
                'default' => '',
            ],
        };
    }

    /**
     * Add database constraints that go beyond column definitions.
     *
     * Silently skips constraints that already exist (idempotent).
     */
    private function addConstraints(): void
    {
        $schema = $this->database->schema();

        if ($schema->tableExists('trade')) {
            try {
                $schema->addUniqueKey('trade', 'trade_challenge_position', ['challenge_id', 'position']);
            } catch (\Exception) {
                // Constraint already exists — idempotent.
            }
        }
    }
}
