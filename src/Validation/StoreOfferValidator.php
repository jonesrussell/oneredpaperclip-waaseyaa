<?php

declare(strict_types=1);

namespace OneRedPaperclip\Validation;

final class StoreOfferValidator
{
    /** @param array<string, mixed> $data */
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        if (!isset($data['offered_item']) || !\is_array($data['offered_item'])) {
            $errors['offered_item'][] = 'Offered item is required.';
        } else {
            if (!isset($data['offered_item']['title']) || $data['offered_item']['title'] === '') {
                $errors['offered_item.title'][] = 'Offered item title is required.';
            } elseif (mb_strlen($data['offered_item']['title']) > 255) {
                $errors['offered_item.title'][] = 'Offered item title must not exceed 255 characters.';
            }

            if (isset($data['offered_item']['description']) && mb_strlen($data['offered_item']['description']) > 2000) {
                $errors['offered_item.description'][] = 'Description must not exceed 2000 characters.';
            }
        }

        if (isset($data['message']) && mb_strlen($data['message']) > 2000) {
            $errors['message'][] = 'Message must not exceed 2000 characters.';
        }

        return new ValidationResult($errors);
    }
}
