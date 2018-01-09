<?php

namespace Framework\Validator;

use Framework\Validator;

class NotNullValidator extends Validator
{
    public function isValid($value): bool
    {
        return $value != '';
    }
}
