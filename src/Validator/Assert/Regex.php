<?php

declare(strict_types=1);

namespace SubRip\Validator\Assert;

use Attribute;
use SubRip\Validator\Constraint;

use function preg_match;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
final readonly class Regex implements Constraint
{
    public function __construct(
        private string $pattern,
    ) {
    }

    public function __invoke(mixed $value): bool
    {
        return (bool) preg_match($this->pattern, $value);
    }
}
