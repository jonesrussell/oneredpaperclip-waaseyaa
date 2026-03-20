<?php

declare(strict_types=1);

namespace OneRedPaperclip\Action;

/**
 * AI-powered text suggestions for challenge creation.
 *
 * Stub implementation — returns placeholder suggestions.
 * Wire to waaseyaa/ai-pipeline when AI infrastructure is ready.
 */
final class SuggestChallengeText
{
    /**
     * @param 'start_item'|'goal_item'|'story' $context
     * @return array{suggestion: string}
     */
    public function execute(string $context, string $currentText = '', string $titleHint = ''): array
    {
        return match ($context) {
            'start_item' => [
                'suggestion' => $this->suggestStartItem($titleHint),
            ],
            'goal_item' => [
                'suggestion' => $this->suggestGoalItem($titleHint),
            ],
            'story' => [
                'suggestion' => $this->suggestStory($currentText, $titleHint),
            ],
        };
    }

    private function suggestStartItem(string $hint): string
    {
        if ($hint !== '') {
            return "A well-loved {$hint} ready for its next adventure.";
        }

        return 'A small but meaningful item to kick off your trading journey.';
    }

    private function suggestGoalItem(string $hint): string
    {
        if ($hint !== '') {
            return "An amazing {$hint} — the ultimate goal of this challenge!";
        }

        return 'Something bigger and better — what will you trade up to?';
    }

    private function suggestStory(string $currentText, string $hint): string
    {
        if ($currentText !== '') {
            return $currentText . ' Join me on this trading adventure!';
        }

        if ($hint !== '') {
            return "Starting with a {$hint}, I'm trading my way up. Each trade brings me closer to my goal. Want to be part of the journey?";
        }

        return "I'm starting small and dreaming big. Through a series of trades, I'll work my way up to something amazing. Every trade counts!";
    }
}
