<?php

declare(strict_types=1);

namespace SubRip\Exception;

use Exception;

use function sprintf;

final class InvalidEntityException extends Exception
{
    public static function forEntity(string $expectedClass, string $receiveClass): self
    {
        return new self(sprintf('Expected entity [%s] but received [%s]', $expectedClass, $receiveClass));
    }
}
