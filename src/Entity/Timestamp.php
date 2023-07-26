<?php

declare(strict_types=1);

namespace SubRip\Entity;

use Stringable;
use SubRip\Validator\Assert as Assert;

use function sprintf;

final class Timestamp implements Stringable
{
    public function __construct(
        #[Assert\Range(min: 0, max: 99)]
        public int $hour,
        #[Assert\Range(min: 0, max: 59)]
        public int $minute,
        #[Assert\Range(min: 0, max: 59)]
        public int $second,
        #[Assert\Range(min: 0, max: 999)]
        public int $microsecond,
    ){
    }

    public function __toString(): string
    {
        return sprintf(
            '%02d:%02d:%02d,%03d',
            $this->hour,
            $this->minute,
            $this->second,
            $this->microsecond
        );
    }
}
