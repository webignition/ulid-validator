<?php

declare(strict_types=1);

namespace webignition\UlidValidator;

class ValidationResult
{
    public const REASON_NONE = 0;
    public const REASON_EMPTY = 1;
    public const REASON_TOO_SHORT = 2;
    public const REASON_TOO_LONG = 3;
    public const REASON_CONTAINS_INVALID_CHARACTERS = 4;
    public const REASON_TOO_LARGE = 5;

    /**
     * @param bool $isValid
     * @param self::REASON_* $reasonCode
     */
    public function __construct(
        private bool $isValid,
        private int $reasonCode = 0,
    ) {
    }

    /**
     * @param self::REASON_* $reasonCode
     */
    public static function createInvalid(int $reasonCode): self
    {
        return new ValidationResult(false, $reasonCode);
    }

    public static function createValid(): self
    {
        return new ValidationResult(true);
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getReasonCode(): int
    {
        return $this->reasonCode;
    }
}
