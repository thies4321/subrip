<?php

declare(strict_types=1);

namespace SubRip\Entity;

final class Subtitle
{
    public function __construct(
        public Timestamp $startTime,
        public Timestamp $endTime,
        /** @var array<string> $text */
        public array $text,
    ) {
    }
}
