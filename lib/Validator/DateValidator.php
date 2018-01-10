<?php

namespace Framework\Validator;

use Framework\Validator;

class DateValidator extends Validator
{
    public function isValid($value):bool
    {
        if (isset($value['month']) and isset($value['day']) and isset($value['year'])) {
            $date = new \DateTime($value['month']."/".$value['day']."/".$value['year']);
            return checkdate((int)$value['month'], (int)$value['day'], (int)$value['year']);
        }

        return false;
    }
}
