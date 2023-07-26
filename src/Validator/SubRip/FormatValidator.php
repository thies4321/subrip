<?php

declare(strict_types=1);

namespace SubRip\Validator\SubRip;

use ReflectionException;
use SubRip\Validator\Assert as Assert;
use SubRip\Validator\Validator;

use function is_string;

final class FormatValidator extends Validator
{
    /**
     * @throws ReflectionException
     */
    #[Assert\Regex('/([0-9]+)(?:\r\n|\r|\n)([0-9]{2}:[0-9]{2}:[0-9]{2}(?:,|\.)[0-9]{3}) --> ([0-9]{2}:[0-9]{2}:[0-9]{2}(?:,|\.)[0-9]{3})(.*)(?:\r\n|\r|\n)((?:.*(?:\r\n|\r|\n))*?)(?:\r\n|\r|\n)/')]
    public function validate(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        return parent::validate($value);
    }
}
