<?php

declare(strict_types=1);

namespace webignition\UlidValidator;

class Validator
{
    public const ULID_LENGTH = 26;
    public const ALLOWED_CHARACTERS = '0123456789ABCDEFGHJKMNPQRSTVWXYZabcdefghjkmnpqrstvwxyz';

    public function validate(string $value): ValidationResult
    {
        $value = trim($value);

        if ('' === $value) {
            return ValidationResult::createInvalid(ValidationResult::REASON_EMPTY);
        }

        $length = \strlen($value);
        if ($length < self::ULID_LENGTH) {
            return ValidationResult::createInvalid(ValidationResult::REASON_TOO_SHORT);
        }

        if ($length > self::ULID_LENGTH) {
            return ValidationResult::createInvalid(ValidationResult::REASON_TOO_LONG);
        }

        if ($length !== strspn($value, self::ALLOWED_CHARACTERS)) {
            return ValidationResult::createInvalid(ValidationResult::REASON_CONTAINS_INVALID_CHARACTERS);
        }

        // Largest valid ULID is '7ZZZZZZZZZZZZZZZZZZZZZZZZZ'
        // Cf https://github.com/ulid/spec#overflow-errors-when-parsing-base32-strings
        if ($value[0] > '7') {
            return ValidationResult::createInvalid(ValidationResult::REASON_TOO_LARGE);
        }

        return ValidationResult::createValid();
    }

    public function isValid(string $value): bool
    {
        return $this->validate($value)->isValid();
    }
}
