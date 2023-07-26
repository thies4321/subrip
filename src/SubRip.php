<?php

declare(strict_types=1);

namespace SubRip;

use ArrayIterator;
use ReflectionException;
use Stringable;
use SubRip\Entity\Subtitle;
use SubRip\Exception\FileNotFoundException;
use SubRip\Exception\SubRipFormatException;
use SubRip\Parser\SubRipParser;
use SubRip\Validator\SubRip\FormatValidator;
use SubRip\Validator\SubRip\SubRipValidator;

use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function implode;
use function is_file;
use function sprintf;

use const PHP_EOL;

final class SubRip extends ArrayIterator implements Stringable
{
    public function __construct(object|array $array = [], int $flags = 0)
    {
        parent::__construct($array, $flags);
    }

    /**
     * @throws FileNotFoundException
     * @throws ReflectionException
     * @throws SubRipFormatException
     */
    public static function fromFile(string $path): self
    {
        if (! file_exists($path)) {
            throw FileNotFoundException::forPath($path);
        }

        if (! is_file($path)) {
            throw FileNotFoundException::forInvalidType($path);
        }

        return self::fromString(file_get_contents($path));
    }

    /**
     * @throws ReflectionException
     * @throws SubRipFormatException
     */
    public static function fromString(string $srt): self
    {
        $formatValidator = new FormatValidator();

        if ($formatValidator->validate($srt) === false) {
            throw SubRipFormatException::forData();
        }

        return new self((new SubRipParser)->toSubtitles($srt));
    }

    public function toFile(string $path): void
    {
        file_put_contents($path, $this->toString());
    }

    public function toString(): string
    {
        $srt = '';

        /** @var Subtitle $subtitle */
        foreach ($this as $position => $subtitle) {
            $srt .= ($position + 1) . PHP_EOL;
            $srt .= sprintf('%s --> %s', $subtitle->startTime, $subtitle->endTime) . PHP_EOL;
            $srt .= implode(PHP_EOL, $subtitle->text) . PHP_EOL . PHP_EOL;
        }

        $srt .= PHP_EOL;

        return $srt;
    }

    /**
     * @throws ReflectionException
     */
    public function validate(): bool
    {
        return (new SubRipValidator)->validate($this);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
