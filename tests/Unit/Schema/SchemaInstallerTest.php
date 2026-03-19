<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Schema;

use OneRedPaperclip\Schema\SchemaInstaller;
use OneRedPaperclip\TradeUpServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Waaseyaa\Database\DBALDatabase;

#[CoversClass(SchemaInstaller::class)]
final class SchemaInstallerTest extends TestCase
{
    private DBALDatabase $database;

    protected function setUp(): void
    {
        $this->database = DBALDatabase::createSqlite();

        $provider = new TradeUpServiceProvider();
        $provider->register();

        $installer = new SchemaInstaller($this->database, $provider->getEntityTypes());
        $installer->install();
    }

    #[Test]
    public function createsAllTenTables(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->tableExists('challenge'));
        $this->assertTrue($schema->tableExists('item'));
        $this->assertTrue($schema->tableExists('offer'));
        $this->assertTrue($schema->tableExists('trade'));
        $this->assertTrue($schema->tableExists('comment'));
        $this->assertTrue($schema->tableExists('follow'));
        $this->assertTrue($schema->tableExists('notification'));
        $this->assertTrue($schema->tableExists('user'));
        $this->assertTrue($schema->tableExists('category'));
        $this->assertTrue($schema->tableExists('media'));
    }

    #[Test]
    public function challengeTableHasBaseColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('challenge', 'id'));
        $this->assertTrue($schema->fieldExists('challenge', 'uuid'));
        $this->assertTrue($schema->fieldExists('challenge', 'title'));
        $this->assertTrue($schema->fieldExists('challenge', 'langcode'));
        $this->assertTrue($schema->fieldExists('challenge', '_data'));
    }

    #[Test]
    public function challengeTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('challenge', 'slug'));
        $this->assertTrue($schema->fieldExists('challenge', 'story'));
        $this->assertTrue($schema->fieldExists('challenge', 'status'));
        $this->assertTrue($schema->fieldExists('challenge', 'visibility'));
        $this->assertTrue($schema->fieldExists('challenge', 'user_id'));
        $this->assertTrue($schema->fieldExists('challenge', 'category_id'));
        $this->assertTrue($schema->fieldExists('challenge', 'current_item_id'));
        $this->assertTrue($schema->fieldExists('challenge', 'goal_item_id'));
        $this->assertTrue($schema->fieldExists('challenge', 'trades_count'));
        $this->assertTrue($schema->fieldExists('challenge', 'created_at'));
        $this->assertTrue($schema->fieldExists('challenge', 'updated_at'));
        $this->assertTrue($schema->fieldExists('challenge', 'deleted_at'));
    }

    #[Test]
    public function itemTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('item', 'title'));
        $this->assertTrue($schema->fieldExists('item', 'description'));
        $this->assertTrue($schema->fieldExists('item', 'role'));
        $this->assertTrue($schema->fieldExists('item', 'itemable_type'));
        $this->assertTrue($schema->fieldExists('item', 'itemable_id'));
        $this->assertTrue($schema->fieldExists('item', 'estimated_value'));
        $this->assertTrue($schema->fieldExists('item', 'created_at'));
        $this->assertTrue($schema->fieldExists('item', 'updated_at'));
    }

    #[Test]
    public function offerTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('offer', 'from_user_id'));
        $this->assertTrue($schema->fieldExists('offer', 'challenge_id'));
        $this->assertTrue($schema->fieldExists('offer', 'offered_item_id'));
        $this->assertTrue($schema->fieldExists('offer', 'for_challenge_item_id'));
        $this->assertTrue($schema->fieldExists('offer', 'status'));
        $this->assertTrue($schema->fieldExists('offer', 'message'));
        $this->assertTrue($schema->fieldExists('offer', 'expires_at'));
        $this->assertTrue($schema->fieldExists('offer', 'created_at'));
        $this->assertTrue($schema->fieldExists('offer', 'updated_at'));
    }

    #[Test]
    public function tradeTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('trade', 'challenge_id'));
        $this->assertTrue($schema->fieldExists('trade', 'offer_id'));
        $this->assertTrue($schema->fieldExists('trade', 'position'));
        $this->assertTrue($schema->fieldExists('trade', 'offered_item_id'));
        $this->assertTrue($schema->fieldExists('trade', 'received_item_id'));
        $this->assertTrue($schema->fieldExists('trade', 'status'));
        $this->assertTrue($schema->fieldExists('trade', 'confirmed_by_owner_at'));
        $this->assertTrue($schema->fieldExists('trade', 'confirmed_by_offerer_at'));
        $this->assertTrue($schema->fieldExists('trade', 'created_at'));
        $this->assertTrue($schema->fieldExists('trade', 'updated_at'));
    }

    #[Test]
    public function commentTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('comment', 'body'));
        $this->assertTrue($schema->fieldExists('comment', 'user_id'));
        $this->assertTrue($schema->fieldExists('comment', 'commentable_type'));
        $this->assertTrue($schema->fieldExists('comment', 'commentable_id'));
        $this->assertTrue($schema->fieldExists('comment', 'parent_id'));
        $this->assertTrue($schema->fieldExists('comment', 'created_at'));
        $this->assertTrue($schema->fieldExists('comment', 'updated_at'));
    }

    #[Test]
    public function followTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('follow', 'user_id'));
        $this->assertTrue($schema->fieldExists('follow', 'followable_type'));
        $this->assertTrue($schema->fieldExists('follow', 'followable_id'));
        $this->assertTrue($schema->fieldExists('follow', 'created_at'));
        $this->assertTrue($schema->fieldExists('follow', 'updated_at'));
    }

    #[Test]
    public function notificationTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('notification', 'user_id'));
        $this->assertTrue($schema->fieldExists('notification', 'type'));
        $this->assertTrue($schema->fieldExists('notification', 'data'));
        $this->assertTrue($schema->fieldExists('notification', 'read_at'));
        $this->assertTrue($schema->fieldExists('notification', 'created_at'));
        $this->assertTrue($schema->fieldExists('notification', 'updated_at'));
    }

    #[Test]
    public function installIsIdempotent(): void
    {
        $provider = new TradeUpServiceProvider();
        $provider->register();

        $installer = new SchemaInstaller($this->database, $provider->getEntityTypes());

        // Second install should not throw.
        $installer->install();

        $this->assertTrue($this->database->schema()->tableExists('challenge'));
    }

    #[Test]
    public function tradeTableHasUniqueConstraintOnChallengeIdPosition(): void
    {
        $this->database->insert('trade')
            ->fields(['uuid', 'bundle', 'label', 'langcode', '_data', 'challenge_id', 'position', 'status'])
            ->values([
                'uuid' => 'uuid-1',
                'bundle' => '',
                'label' => '',
                'langcode' => 'en',
                '_data' => '{}',
                'challenge_id' => 1,
                'position' => 1,
                'status' => 'pending_confirmation',
            ])
            ->execute();

        $this->expectException(\Exception::class);

        $this->database->insert('trade')
            ->fields(['uuid', 'bundle', 'label', 'langcode', '_data', 'challenge_id', 'position', 'status'])
            ->values([
                'uuid' => 'uuid-2',
                'bundle' => '',
                'label' => '',
                'langcode' => 'en',
                '_data' => '{}',
                'challenge_id' => 1,
                'position' => 1,
                'status' => 'pending_confirmation',
            ])
            ->execute();
    }

    #[Test]
    public function challengeSlugHasUniqueConstraint(): void
    {
        $this->database->insert('challenge')
            ->fields(['uuid', 'bundle', 'title', 'langcode', '_data', 'slug', 'status', 'visibility'])
            ->values([
                'uuid' => 'uuid-1',
                'bundle' => '',
                'title' => 'Challenge 1',
                'langcode' => 'en',
                '_data' => '{}',
                'slug' => 'my-challenge',
                'status' => 'active',
                'visibility' => 'public',
            ])
            ->execute();

        $this->expectException(\Exception::class);

        $this->database->insert('challenge')
            ->fields(['uuid', 'bundle', 'title', 'langcode', '_data', 'slug', 'status', 'visibility'])
            ->values([
                'uuid' => 'uuid-2',
                'bundle' => '',
                'title' => 'Challenge 2',
                'langcode' => 'en',
                '_data' => '{}',
                'slug' => 'my-challenge',
                'status' => 'active',
                'visibility' => 'public',
            ])
            ->execute();
    }

    #[Test]
    public function followHasUniqueConstraintOnUserFollowable(): void
    {
        $this->database->insert('follow')
            ->fields(['uuid', 'bundle', 'label', 'langcode', '_data', 'user_id', 'followable_type', 'followable_id'])
            ->values([
                'uuid' => 'uuid-1',
                'bundle' => '',
                'label' => '',
                'langcode' => 'en',
                '_data' => '{}',
                'user_id' => 1,
                'followable_type' => 'challenge',
                'followable_id' => 5,
            ])
            ->execute();

        $this->expectException(\Exception::class);

        $this->database->insert('follow')
            ->fields(['uuid', 'bundle', 'label', 'langcode', '_data', 'user_id', 'followable_type', 'followable_id'])
            ->values([
                'uuid' => 'uuid-2',
                'bundle' => '',
                'label' => '',
                'langcode' => 'en',
                '_data' => '{}',
                'user_id' => 1,
                'followable_type' => 'challenge',
                'followable_id' => 5,
            ])
            ->execute();
    }

    #[Test]
    public function userTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('user', 'name'));
        $this->assertTrue($schema->fieldExists('user', 'email'));
        $this->assertTrue($schema->fieldExists('user', 'password'));
        $this->assertTrue($schema->fieldExists('user', 'profile_photo_path'));
        $this->assertTrue($schema->fieldExists('user', 'is_admin'));
        $this->assertTrue($schema->fieldExists('user', 'xp'));
        $this->assertTrue($schema->fieldExists('user', 'level'));
        $this->assertTrue($schema->fieldExists('user', 'current_streak'));
        $this->assertTrue($schema->fieldExists('user', 'longest_streak'));
        $this->assertTrue($schema->fieldExists('user', 'last_activity_at'));
        $this->assertTrue($schema->fieldExists('user', 'email_verified_at'));
        $this->assertTrue($schema->fieldExists('user', 'notification_preferences'));
        $this->assertTrue($schema->fieldExists('user', 'created_at'));
        $this->assertTrue($schema->fieldExists('user', 'updated_at'));
    }

    #[Test]
    public function categoryTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('category', 'name'));
        $this->assertTrue($schema->fieldExists('category', 'slug'));
        $this->assertTrue($schema->fieldExists('category', 'created_at'));
        $this->assertTrue($schema->fieldExists('category', 'updated_at'));
    }

    #[Test]
    public function mediaTableHasDomainColumns(): void
    {
        $schema = $this->database->schema();

        $this->assertTrue($schema->fieldExists('media', 'model_type'));
        $this->assertTrue($schema->fieldExists('media', 'model_id'));
        $this->assertTrue($schema->fieldExists('media', 'collection_name'));
        $this->assertTrue($schema->fieldExists('media', 'file_name'));
        $this->assertTrue($schema->fieldExists('media', 'disk'));
        $this->assertTrue($schema->fieldExists('media', 'path'));
        $this->assertTrue($schema->fieldExists('media', 'size'));
        $this->assertTrue($schema->fieldExists('media', 'created_at'));
        $this->assertTrue($schema->fieldExists('media', 'updated_at'));
    }

    #[Test]
    public function userEmailHasUniqueConstraint(): void
    {
        $this->database->insert('user')
            ->fields(['uuid', 'bundle', 'name', 'langcode', '_data', 'email', 'password'])
            ->values([
                'uuid' => 'uuid-1',
                'bundle' => '',
                'name' => 'User 1',
                'langcode' => 'en',
                '_data' => '{}',
                'email' => 'dupe@example.com',
                'password' => 'hashed',
            ])
            ->execute();

        $this->expectException(\Exception::class);

        $this->database->insert('user')
            ->fields(['uuid', 'bundle', 'name', 'langcode', '_data', 'email', 'password'])
            ->values([
                'uuid' => 'uuid-2',
                'bundle' => '',
                'name' => 'User 2',
                'langcode' => 'en',
                '_data' => '{}',
                'email' => 'dupe@example.com',
                'password' => 'hashed',
            ])
            ->execute();
    }

    #[Test]
    public function categorySlugHasUniqueConstraint(): void
    {
        $this->database->insert('category')
            ->fields(['uuid', 'bundle', 'name', 'langcode', '_data', 'slug'])
            ->values([
                'uuid' => 'uuid-1',
                'bundle' => '',
                'name' => 'Category 1',
                'langcode' => 'en',
                '_data' => '{}',
                'slug' => 'electronics',
            ])
            ->execute();

        $this->expectException(\Exception::class);

        $this->database->insert('category')
            ->fields(['uuid', 'bundle', 'name', 'langcode', '_data', 'slug'])
            ->values([
                'uuid' => 'uuid-2',
                'bundle' => '',
                'name' => 'Category 2',
                'langcode' => 'en',
                '_data' => '{}',
                'slug' => 'electronics',
            ])
            ->execute();
    }
}
