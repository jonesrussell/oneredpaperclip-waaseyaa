<?php

declare(strict_types=1);

namespace OneRedPaperclip\Validation;

final class StoreChallengeValidator
{
    /** @param array<string, mixed> $data */
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        if (!isset($data['title']) || !\is_string($data['title']) || $data['title'] === '') {
            $errors['title'][] = 'Title is required.';
        } elseif (mb_strlen($data['title']) > 255) {
            $errors['title'][] = 'Title must not exceed 255 characters.';
        }

        if (!isset($data['slug']) || !\is_string($data['slug']) || $data['slug'] === '') {
            $errors['slug'][] = 'Slug is required.';
        } elseif (mb_strlen($data['slug']) > 255) {
            $errors['slug'][] = 'Slug must not exceed 255 characters.';
        }

        if (isset($data['story']) && !\is_string($data['story'])) {
            $errors['story'][] = 'Story must be a string.';
        } elseif (isset($data['story']) && mb_strlen($data['story']) > 2000) {
            $errors['story'][] = 'Story must not exceed 2000 characters.';
        }

        if (isset($data['status']) && !\in_array($data['status'], ['draft', 'active'], true)) {
            $errors['status'][] = 'Status must be draft or active.';
        }

        if (isset($data['visibility']) && !\in_array($data['visibility'], ['public', 'unlisted'], true)) {
            $errors['visibility'][] = 'Visibility must be public or unlisted.';
        }

        if (!isset($data['start_item']) || !\is_array($data['start_item'])) {
            $errors['start_item'][] = 'Start item is required.';
        } else {
            if (!isset($data['start_item']['title']) || $data['start_item']['title'] === '') {
                $errors['start_item.title'][] = 'Start item title is required.';
            } elseif (mb_strlen($data['start_item']['title']) > 255) {
                $errors['start_item.title'][] = 'Start item title must not exceed 255 characters.';
            }
        }

        if (!isset($data['goal_item']) || !\is_array($data['goal_item'])) {
            $errors['goal_item'][] = 'Goal item is required.';
        } else {
            if (!isset($data['goal_item']['title']) || $data['goal_item']['title'] === '') {
                $errors['goal_item.title'][] = 'Goal item title is required.';
            } elseif (mb_strlen($data['goal_item']['title']) > 255) {
                $errors['goal_item.title'][] = 'Goal item title must not exceed 255 characters.';
            }
        }

        return new ValidationResult($errors);
    }
}
