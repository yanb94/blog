<?php

namespace Framework\Validator;

use Framework\Validator;

class EmailValidator extends Validator
{
    public function isValid($value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}
