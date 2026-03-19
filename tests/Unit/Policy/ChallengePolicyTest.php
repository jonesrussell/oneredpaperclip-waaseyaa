<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Policy;

use OneRedPaperclip\Entity\Challenge;
use OneRedPaperclip\Policy\ChallengePolicy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChallengePolicy::class)]
final class ChallengePolicyTest extends TestCase
{
    private ChallengePolicy $policy;

    protected function setUp(): void
    {
        $this->policy = new ChallengePolicy();
    }

    #[Test]
    public function ownerCanUpdate(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);

        $this->assertTrue($this->policy->update(1, $challenge));
    }

    #[Test]
    public function nonOwnerCannotUpdate(): void
    {
        $challenge = new Challenge(['title' => 'Test', 'user_id' => 1]);

        $this->assertFalse($this->policy->update(2, $challenge));
    }
}
