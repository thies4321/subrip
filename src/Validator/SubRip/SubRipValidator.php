<?php

declare(strict_types=1);

namespace SubRip\Validator\SubRip;

use ReflectionException;
use SubRip\SubRip;
use SubRip\Validator\Assert\IsValidSubRip;
use SubRip\Validator\Validator;

final class SubRipValidator extends Validator
{
    /**
     * @throws ReflectionException
     */
    #[IsValidSubRip]
    public function validate(mixed $value): bool
    {
        if (! $value instanceof SubRip) {
            return false;
        }

        return parent::validate($value);
    }
}
