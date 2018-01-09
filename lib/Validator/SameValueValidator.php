<?php

namespace Framework\Validator;

use Framework\Validator;

class SameValueValidator extends Validator
{
    public function isValid(array $value):bool
    {
        $control;

        foreach ($value as $fieldValue) {
            if (empty($control)) {
                $control = $fieldValue;
            } else {
                if ($control != $fieldValue) {
                    return false;
                }
            }
        }

        return true;
    }
}
