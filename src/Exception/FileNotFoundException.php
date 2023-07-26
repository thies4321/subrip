<?php

declare(strict_types=1);

namespace SubRip\Exception;

use Exception;

use function sprintf;

final class FileNotFoundException extends Exception
{
    public static function forPath(string $path): self
    {
        return new self(sprintf('File [%s] does not exist', $path));
    }

    public static function forInvalidType(string $path): self
    {
        return new self(sprintf('[%s] is not a file', $path));
    }
}
