<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Service;

use OneRedPaperclip\Enum\ChallengeStatus;
use OneRedPaperclip\Service\ChallengeWorkflow;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChallengeWorkflow::class)]
final class ChallengeWorkflowTest extends TestCase
{
    private ChallengeWorkflow $workflow;

    protected function setUp(): void
    {
        $this->workflow = new ChallengeWorkflow();
    }

    #[Test]
    public function draftCanTransitionToActive(): void
    {
        $this->assertTrue($this->workflow->canTransition(ChallengeStatus::Draft, ChallengeStatus::Active));
    }

    #[Test]
    public function draftCannotTransitionToCompleted(): void
    {
        $this->assertFalse($this->workflow->canTransition(ChallengeStatus::Draft, ChallengeStatus::Completed));
    }

    #[Test]
    public function activeCanTransitionToPaused(): void
    {
        $this->assertTrue($this->workflow->canTransition(ChallengeStatus::Active, ChallengeStatus::Paused));
    }

    #[Test]
    public function activeCanTransitionToCompleted(): void
    {
        $this->assertTrue($this->workflow->canTransition(ChallengeStatus::Active, ChallengeStatus::Completed));
    }

    #[Test]
    public function completedCannotTransitionAnywhere(): void
    {
        $this->assertSame([], $this->workflow->allowedTransitions(ChallengeStatus::Completed));
    }

    #[Test]
    public function pausedCanResumeToActive(): void
    {
        $this->assertTrue($this->workflow->canTransition(ChallengeStatus::Paused, ChallengeStatus::Active));
    }

    #[Test]
    public function transitionThrowsOnInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->workflow->transition(ChallengeStatus::Draft, ChallengeStatus::Completed);
    }

    #[Test]
    public function transitionReturnsTargetOnValid(): void
    {
        $result = $this->workflow->transition(ChallengeStatus::Draft, ChallengeStatus::Active);

        $this->assertSame(ChallengeStatus::Active, $result);
    }

    #[Test]
    public function allowedTransitionsReturnsList(): void
    {
        $allowed = $this->workflow->allowedTransitions(ChallengeStatus::Active);

        $this->assertContains(ChallengeStatus::Paused, $allowed);
        $this->assertContains(ChallengeStatus::Completed, $allowed);
        $this->assertContains(ChallengeStatus::Draft, $allowed);
    }
}
