<?php

declare(strict_types=1);

namespace SubRip\Validator\Assert;

use Attribute;
use ReflectionAttribute;
use ReflectionClass;
use SubRip\Entity\Subtitle;
use SubRip\Entity\Timestamp;
use SubRip\SubRip;
use SubRip\Validator\Constraint;

use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final readonly class IsValidSubRip implements Constraint
{
    public function __invoke(mixed $value): bool
    {
        if (! $value instanceof SubRip) {
            return false;
        }

        $value->rewind();

        foreach ($value as $subtitle) {
            if ($this->validateSubtitle($subtitle) === false) {
                return false;
            }
        }

        return true;
    }

    private function validateSubtitle(Subtitle $subtitle): bool
    {
        if ($this->validateTimestamp($subtitle->startTime) === false) {
            return false;
        }

        if ($this->validateTimestamp($subtitle->endTime) === false) {
            return false;
        }

        foreach ($subtitle->text as $text) {
            if (! is_string($text)) {
                return false;
            }
        }

        return true;
    }

    public function validateTimestamp(Timestamp $timestamp): bool
    {
        $reflectionClass = new ReflectionClass($timestamp);
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyName = $reflectionProperty->getName();
            $attributes = $reflectionProperty->getAttributes(Constraint::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                /** @var Constraint $constraint */
                $constraint = $attribute->newInstance();

                if ($constraint($timestamp->$propertyName) === false) {
                    return false;
                }
            }
        }

        return true;
    }
}
