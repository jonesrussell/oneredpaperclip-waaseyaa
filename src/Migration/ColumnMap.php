<?php

declare(strict_types=1);

namespace OneRedPaperclip\Migration;

/**
 * Maps Laravel column names and values to Waaseyaa equivalents.
 *
 * Per ADR-001 (enum alignment) and ADR-002 (column names), Waaseyaa
 * now matches Laravel names exactly. This class handles the structural
 * differences: adding Waaseyaa-required columns (uuid, bundle, label,
 * langcode, _data) and converting Laravel timestamps to ISO 8601.
 */
final class ColumnMap
{
    /**
     * Column mappings per entity type: laravel_column => waaseyaa_column.
     * Only columns that differ are listed. Identical columns pass through.
     *
     * @return array<string, array<string, string>>
     */
    public static function columnMappings(): array
    {
        return [
            'challenges' => [
                'story' => 'story',
                'category_id' => 'category_id',
            ],
            'offers' => [
                'from_user_id' => 'from_user_id',
                'offered_item_id' => 'offered_item_id',
                'for_challenge_item_id' => 'for_challenge_item_id',
            ],
        ];
    }

    /**
     * Columns to skip during migration (handled separately or not applicable).
     *
     * @return array<string, list<string>>
     */
    public static function skipColumns(): array
    {
        return [
            'challenges' => ['remember_token'],
            'users' => ['remember_token', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'reputation_score', 'verified_at'],
            'notifications' => ['notifiable_type', 'notifiable_id', 'updated_at'],
        ];
    }

    /**
     * Laravel table name => Waaseyaa entity type id.
     *
     * @return array<string, string>
     */
    public static function tableToEntityType(): array
    {
        return [
            'users' => 'user',
            'challenges' => 'challenge',
            'categories' => 'category',
            'items' => 'item',
            'offers' => 'offer',
            'trades' => 'trade',
            'comments' => 'comment',
            'follows' => 'follow',
            'notifications' => 'notification',
            'media' => 'media',
        ];
    }

    /**
     * Label key source for each entity type.
     *
     * @return array<string, string>
     */
    public static function labelSources(): array
    {
        return [
            'challenge' => 'title',
            'item' => 'title',
            'user' => 'name',
            'category' => 'name',
            'offer' => '',
            'trade' => '',
            'comment' => '',
            'follow' => '',
            'notification' => 'type',
            'media' => 'file_name',
        ];
    }

    /**
     * Convert a Laravel timestamp string to ISO 8601 UTC.
     * Laravel: "2026-03-19 12:00:00" => "2026-03-19T12:00:00Z"
     */
    public static function convertTimestamp(?string $laravelTimestamp): ?string
    {
        if ($laravelTimestamp === null || $laravelTimestamp === '') {
            return null;
        }

        // Already ISO 8601 format.
        if (str_contains($laravelTimestamp, 'T')) {
            return $laravelTimestamp;
        }

        // Laravel format: "YYYY-MM-DD HH:MM:SS"
        return str_replace(' ', 'T', $laravelTimestamp) . 'Z';
    }
}
