<?php

declare(strict_types=1);

namespace webignition\UlidValidator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use webignition\UlidValidator\ValidationResult;
use webignition\UlidValidator\Validator;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider validateDataProvider
     */
    public function testValidate(string $value, ValidationResult $expectedResult): void
    {
        self::assertEquals($expectedResult, (new Validator())->validate($value));
    }

    /**
     * @return array[]
     */
    public function validateDataProvider(): array
    {
        return [
            'invalid: empty' => [
                'value' => '',
                'expectedResult' => ValidationResult::createInvalid(ValidationResult::REASON_EMPTY),
            ],
            'invalid: too short' => [
                'value' => 'a',
                'expectedResult' => ValidationResult::createInvalid(ValidationResult::REASON_TOO_SHORT),
            ],
            'invalid: too long' => [
                'value' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaa',
                'expectedResult' => ValidationResult::createInvalid(ValidationResult::REASON_TOO_LONG),
            ],
            'invalid: contains invalid characters' => [
                'value' => '$aaaaaaaaaaaaaaaaaaaaaaaaa',
                'expectedResult' => ValidationResult::createInvalid(
                    ValidationResult::REASON_CONTAINS_INVALID_CHARACTERS
                ),
            ],
            'invalid: too large' => [
                'value' => '8ZZZZZZZZZZZZZZZZZZZZZZZZZ',
                'expectedResult' => ValidationResult::createInvalid(ValidationResult::REASON_TOO_LARGE),
            ],
            'valid' => [
                'value' => '01F3AVQ2YHFVQ4E0STHE4Z8KXH',
                'expectedResult' => ValidationResult::createValid(),
            ],
        ];
    }
}
