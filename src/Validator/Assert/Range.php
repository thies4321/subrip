<?php

declare(strict_types=1);

namespace SubRip\Validator\Assert;

use Attribute;
use SubRip\Validator\Constraint;

use function is_integer;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class Range implements Constraint
{
    public function __construct(
        private int $min,
        private int $max,
    ) {
    }

    public function __invoke(mixed $value): bool
    {
        if (! is_integer($value)) {
            return false;
        }

        return ($value >= $this->min) && $value <= $this->max;
    }
}
