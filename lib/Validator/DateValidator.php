<?php

namespace Framework\Validator;

use Framework\Validator;

class DateValidator extends Validator
{
    public function isValid($value):bool
    {
        if (isset($value['month']) && isset($value['day']) && isset($value['year'])) {
            return checkdate((int)$value['month'], (int)$value['day'], (int)$value['year']);
        }

        return false;
    }
}
