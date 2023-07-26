<?php

declare(strict_types=1);

namespace SubRip\Exception;

use Exception;

final class SubRipFormatException extends Exception
{
    public static function forData(): self
    {
        return new self('Provided data is not in valid SubRip format');
    }
}
