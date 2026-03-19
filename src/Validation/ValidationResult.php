<?php

declare(strict_types=1);

namespace OneRedPaperclip\Validation;

final class ValidationResult
{
    /** @param array<string, list<string>> $errors */
    public function __construct(
        private readonly array $errors = [],
    ) {}

    public function passes(): bool
    {
        return $this->errors === [];
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    /** @return array<string, list<string>> */
    public function errors(): array
    {
        return $this->errors;
    }

    /** @return list<string> */
    public function errorsFor(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
