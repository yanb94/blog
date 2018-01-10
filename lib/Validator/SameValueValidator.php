<?php

namespace Framework\Validator;

use Framework\Validator;

class SameValueValidator extends Validator
{
    public function isValid($value):bool
    {
        $control;

        if (!is_null($value)) {
            foreach ($value as $fieldValue) {
                if (empty($control)) {
                    $control = $fieldValue;
                } else {
                    if ($control != $fieldValue) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
