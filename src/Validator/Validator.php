<?php

declare(strict_types=1);

namespace SubRip\Validator;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

abstract class Validator
{
    /**
     * @throws ReflectionException
     */
    public function validate(mixed $value): bool
    {
        $reflectionClass = new ReflectionClass(static::class);
        $constraints = $reflectionClass->getMethod(__FUNCTION__)->getAttributes(Constraint::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($constraints as $constraint) {
            /** @var Constraint $instance */
            $instance = $constraint->newInstance();

            if ($instance($value) === false) {
                return false;
            }
        }

        return true;
    }
}
