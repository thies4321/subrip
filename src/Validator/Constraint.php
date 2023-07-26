<?php

namespace SubRip\Validator;

interface Constraint
{
    public function __invoke(mixed $value): bool;
}
