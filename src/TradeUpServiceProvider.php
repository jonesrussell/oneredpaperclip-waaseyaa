<?php

declare(strict_types=1);

namespace OneRedPaperclip;

use OneRedPaperclip\Entity\Category;
use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Entity\Comment;
use OneRedPaperclip\Entity\Follow;
use OneRedPaperclip\Entity\Item;
use OneRedPaperclip\Entity\Media;
use OneRedPaperclip\Entity\Notification;
use OneRedPaperclip\Entity\Offer;
use OneRedPaperclip\Entity\Trade;
use OneRedPaperclip\Entity\User;
use Waaseyaa\Entity\EntityType;
use Waaseyaa\Foundation\ServiceProvider\ServiceProvider;

final class TradeUpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->entityType(new EntityType(
            id: 'challenge',
            label: 'Challenge',
            class: Challenge::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'title'],
            group: 'content',
            fieldDefinitions: [
                'title' => [
                    'type' => 'string',
                    'label' => 'Title',
                    'required' => true,
                    'weight' => 0,
                ],
                'slug' => [
                    'type' => 'string',
                    'label' => 'Slug',
                    'required' => true,
                    'weight' => 1,
                ],
                'story' => [
                    'type' => 'text',
                    'label' => 'Story',
                    'required' => false,
                    'weight' => 2,
                ],
                'status' => [
                    'type' => 'string',
                    'label' => 'Status',
                    'required' => true,
                    'weight' => 3,
                ],
                'visibility' => [
                    'type' => 'string',
                    'label' => 'Visibility',
                    'required' => true,
                    'weight' => 4,
                ],
                'user_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Owner',
                    'target_entity_type_id' => 'user',
                    'weight' => 5,
                ],
                'category_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Category',
                    'target_entity_type_id' => 'category',
                    'weight' => 6,
                ],
                'current_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Current Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 7,
                ],
                'goal_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Goal Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 8,
                ],
                'trades_count' => [
                    'type' => 'integer',
                    'label' => 'Trades Count',
                    'required' => false,
                    'weight' => 9,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
                'deleted_at' => [
                    'type' => 'timestamp',
                    'label' => 'Deleted at',
                    'required' => false,
                    'weight' => 92,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'item',
            label: 'Item',
            class: Item::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'title'],
            group: 'content',
            fieldDefinitions: [
                'title' => [
                    'type' => 'string',
                    'label' => 'Title',
                    'required' => true,
                    'weight' => 0,
                ],
                'description' => [
                    'type' => 'text',
                    'label' => 'Description',
                    'required' => false,
                    'weight' => 1,
                ],
                'role' => [
                    'type' => 'string',
                    'label' => 'Role',
                    'required' => true,
                    'weight' => 2,
                ],
                'itemable_type' => [
                    'type' => 'string',
                    'label' => 'Itemable Type',
                    'required' => true,
                    'weight' => 3,
                ],
                'itemable_id' => [
                    'type' => 'integer',
                    'label' => 'Itemable ID',
                    'required' => true,
                    'weight' => 4,
                ],
                'estimated_value' => [
                    'type' => 'string',
                    'label' => 'Estimated Value',
                    'required' => false,
                    'weight' => 5,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'offer',
            label: 'Offer',
            class: Offer::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'label'],
            group: 'content',
            fieldDefinitions: [
                'from_user_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Offerer',
                    'target_entity_type_id' => 'user',
                    'weight' => 0,
                ],
                'challenge_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Challenge',
                    'target_entity_type_id' => 'challenge',
                    'weight' => 1,
                ],
                'offered_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Offered Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 2,
                ],
                'for_challenge_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Target Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 3,
                ],
                'status' => [
                    'type' => 'string',
                    'label' => 'Status',
                    'required' => true,
                    'weight' => 4,
                ],
                'message' => [
                    'type' => 'text',
                    'label' => 'Message',
                    'required' => false,
                    'weight' => 5,
                ],
                'expires_at' => [
                    'type' => 'timestamp',
                    'label' => 'Expires At',
                    'required' => false,
                    'weight' => 6,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'trade',
            label: 'Trade',
            class: Trade::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'label'],
            group: 'content',
            fieldDefinitions: [
                'challenge_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Challenge',
                    'target_entity_type_id' => 'challenge',
                    'weight' => 0,
                ],
                'offer_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Offer',
                    'target_entity_type_id' => 'offer',
                    'weight' => 1,
                ],
                'position' => [
                    'type' => 'integer',
                    'label' => 'Position',
                    'required' => true,
                    'weight' => 2,
                ],
                'offered_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Offered Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 3,
                ],
                'received_item_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Received Item',
                    'target_entity_type_id' => 'item',
                    'weight' => 4,
                ],
                'status' => [
                    'type' => 'string',
                    'label' => 'Status',
                    'required' => true,
                    'weight' => 5,
                ],
                'confirmed_by_owner_at' => [
                    'type' => 'timestamp',
                    'label' => 'Confirmed by Owner',
                    'required' => false,
                    'weight' => 6,
                ],
                'confirmed_by_offerer_at' => [
                    'type' => 'timestamp',
                    'label' => 'Confirmed by Offerer',
                    'required' => false,
                    'weight' => 7,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'comment',
            label: 'Comment',
            class: Comment::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'label'],
            group: 'content',
            fieldDefinitions: [
                'body' => [
                    'type' => 'text',
                    'label' => 'Body',
                    'required' => true,
                    'weight' => 0,
                ],
                'user_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Author',
                    'target_entity_type_id' => 'user',
                    'weight' => 1,
                ],
                'commentable_type' => [
                    'type' => 'string',
                    'label' => 'Commentable Type',
                    'required' => true,
                    'weight' => 2,
                ],
                'commentable_id' => [
                    'type' => 'integer',
                    'label' => 'Commentable ID',
                    'required' => true,
                    'weight' => 3,
                ],
                'parent_id' => [
                    'type' => 'integer',
                    'label' => 'Parent Comment',
                    'required' => false,
                    'weight' => 4,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'follow',
            label: 'Follow',
            class: Follow::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'label'],
            group: 'content',
            fieldDefinitions: [
                'user_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Follower',
                    'target_entity_type_id' => 'user',
                    'weight' => 0,
                ],
                'followable_type' => [
                    'type' => 'string',
                    'label' => 'Followable Type',
                    'required' => true,
                    'weight' => 1,
                ],
                'followable_id' => [
                    'type' => 'integer',
                    'label' => 'Followable ID',
                    'required' => true,
                    'weight' => 2,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'notification',
            label: 'Notification',
            class: Notification::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'type'],
            group: 'content',
            fieldDefinitions: [
                'user_id' => [
                    'type' => 'entity_reference',
                    'label' => 'Recipient',
                    'target_entity_type_id' => 'user',
                    'weight' => 0,
                ],
                'type' => [
                    'type' => 'string',
                    'label' => 'Type',
                    'required' => true,
                    'weight' => 1,
                ],
                'data' => [
                    'type' => 'map',
                    'label' => 'Data',
                    'required' => false,
                    'weight' => 2,
                ],
                'read_at' => [
                    'type' => 'timestamp',
                    'label' => 'Read At',
                    'required' => false,
                    'weight' => 3,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'user',
            label: 'User',
            class: User::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'name'],
            group: 'content',
            fieldDefinitions: [
                'name' => [
                    'type' => 'string',
                    'label' => 'Name',
                    'required' => true,
                    'weight' => 0,
                ],
                'email' => [
                    'type' => 'string',
                    'label' => 'Email',
                    'required' => true,
                    'weight' => 1,
                ],
                'password' => [
                    'type' => 'string',
                    'label' => 'Password',
                    'required' => true,
                    'weight' => 2,
                ],
                'profile_photo_path' => [
                    'type' => 'string',
                    'label' => 'Profile Photo',
                    'required' => false,
                    'weight' => 3,
                ],
                'is_admin' => [
                    'type' => 'integer',
                    'label' => 'Admin',
                    'required' => false,
                    'weight' => 4,
                ],
                'xp' => [
                    'type' => 'integer',
                    'label' => 'XP',
                    'required' => false,
                    'weight' => 5,
                ],
                'level' => [
                    'type' => 'integer',
                    'label' => 'Level',
                    'required' => false,
                    'weight' => 6,
                ],
                'current_streak' => [
                    'type' => 'integer',
                    'label' => 'Current Streak',
                    'required' => false,
                    'weight' => 7,
                ],
                'longest_streak' => [
                    'type' => 'integer',
                    'label' => 'Longest Streak',
                    'required' => false,
                    'weight' => 8,
                ],
                'last_activity_at' => [
                    'type' => 'timestamp',
                    'label' => 'Last Activity',
                    'required' => false,
                    'weight' => 9,
                ],
                'email_verified_at' => [
                    'type' => 'timestamp',
                    'label' => 'Email Verified',
                    'required' => false,
                    'weight' => 10,
                ],
                'notification_preferences' => [
                    'type' => 'map',
                    'label' => 'Notification Preferences',
                    'required' => false,
                    'weight' => 11,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'category',
            label: 'Category',
            class: Category::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'name'],
            group: 'content',
            fieldDefinitions: [
                'name' => [
                    'type' => 'string',
                    'label' => 'Name',
                    'required' => true,
                    'weight' => 0,
                ],
                'slug' => [
                    'type' => 'string',
                    'label' => 'Slug',
                    'required' => true,
                    'weight' => 1,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));

        $this->entityType(new EntityType(
            id: 'media',
            label: 'Media',
            class: Media::class,
            keys: ['id' => 'id', 'uuid' => 'uuid', 'label' => 'label'],
            group: 'content',
            fieldDefinitions: [
                'model_type' => [
                    'type' => 'string',
                    'label' => 'Model Type',
                    'required' => true,
                    'weight' => 0,
                ],
                'model_id' => [
                    'type' => 'integer',
                    'label' => 'Model ID',
                    'required' => true,
                    'weight' => 1,
                ],
                'collection_name' => [
                    'type' => 'string',
                    'label' => 'Collection',
                    'required' => false,
                    'weight' => 2,
                ],
                'file_name' => [
                    'type' => 'string',
                    'label' => 'File Name',
                    'required' => true,
                    'weight' => 3,
                ],
                'disk' => [
                    'type' => 'string',
                    'label' => 'Disk',
                    'required' => true,
                    'weight' => 4,
                ],
                'path' => [
                    'type' => 'string',
                    'label' => 'Path',
                    'required' => true,
                    'weight' => 5,
                ],
                'size' => [
                    'type' => 'integer',
                    'label' => 'Size',
                    'required' => false,
                    'weight' => 6,
                ],
                'created_at' => [
                    'type' => 'timestamp',
                    'label' => 'Created',
                    'required' => false,
                    'weight' => 90,
                ],
                'updated_at' => [
                    'type' => 'timestamp',
                    'label' => 'Updated',
                    'required' => false,
                    'weight' => 91,
                ],
            ],
        ));
    }
}
