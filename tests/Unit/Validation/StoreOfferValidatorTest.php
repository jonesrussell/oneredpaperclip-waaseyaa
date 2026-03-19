<?php

declare(strict_types=1);

namespace OneRedPaperclip\Tests\Unit\Validation;

use OneRedPaperclip\Validation\StoreOfferValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(StoreOfferValidator::class)]
final class StoreOfferValidatorTest extends TestCase
{
    private StoreOfferValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new StoreOfferValidator();
    }

    #[Test]
    public function validDataPasses(): void
    {
        $result = $this->validator->validate([
            'offered_item' => ['title' => 'Fish Pen'],
            'message' => 'Want to trade?',
        ]);

        $this->assertTrue($result->passes());
    }

    #[Test]
    public function missingOfferedItemFails(): void
    {
        $result = $this->validator->validate([
            'message' => 'Want to trade?',
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('offered_item'));
    }

    #[Test]
    public function missingOfferedItemTitleFails(): void
    {
        $result = $this->validator->validate([
            'offered_item' => ['description' => 'No title'],
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('offered_item.title'));
    }

    #[Test]
    public function messageTooLongFails(): void
    {
        $result = $this->validator->validate([
            'offered_item' => ['title' => 'Pen'],
            'message' => str_repeat('a', 2001),
        ]);

        $this->assertTrue($result->fails());
        $this->assertNotEmpty($result->errorsFor('message'));
    }

    #[Test]
    public function optionalMessagePasses(): void
    {
        $result = $this->validator->validate([
            'offered_item' => ['title' => 'Pen'],
        ]);

        $this->assertTrue($result->passes());
    }
}
