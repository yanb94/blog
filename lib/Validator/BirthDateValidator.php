<?php

namespace Framework\Validator;

use Framework\Validator;

class BirthDateValidator extends Validator
{
    public function isValid(array $value):bool
    {
        $date = new \DateTime($value['month']."/".$value['day']."/".$value['year']);
        $dateControl = new \DateTime('-13 year');
        
        return $date > $dateControl;
    }
}
