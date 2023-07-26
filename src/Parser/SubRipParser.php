<?php

declare(strict_types=1);

namespace SubRip\Parser;

use SubRip\Entity\Subtitle;
use SubRip\Entity\Timestamp;

use function array_map;
use function array_shift;
use function array_values;
use function explode;
use function preg_split;

final readonly class SubRipParser
{
    /**
     * @return Subtitle[]
     */
    public function toSubtitles(string $srt): array
    {
        $parts = preg_split("/((\r?\n)|(\r\n?))/", $srt);

        $blocks = [];
        $block = [];
        foreach ($parts as $part) {
            $reset = false;
            if (empty($part)) {
                $reset = true;
            }

            if ($reset === true) {
                if (! empty($block)) {
                    $blocks[] = $block;
                }

                $block = [];
                continue;
            }

            $block[] = $part;
        }

        $subtitles = [];
        foreach ($blocks as $block) {
            unset($block[0]);
            $rawTimestamps = array_shift($block);
            $timestamps = $this->parseRawTimestamps($rawTimestamps);

            $subtitles[] = new Subtitle(
                $timestamps[0],
                $timestamps[1],
                array_values($block)
            );
        }

        return $subtitles;
    }

    /**
     * @return Timestamp[]
     */
    private function parseRawTimestamps(string $timestamps): array
    {
        return array_map(function ($timestamp) {
            $timeMicrosecondsParts = explode(',', $timestamp);
            $timestampParts = explode(':', $timeMicrosecondsParts[0]);

            return new Timestamp(
                (int) $timestampParts[0],
                (int) $timestampParts[1],
                (int) $timestampParts[2],
                (int) $timeMicrosecondsParts[1]
            );
        }, explode(' --> ', $timestamps));
    }
}
