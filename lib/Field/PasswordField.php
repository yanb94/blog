<?php

namespace Framework\Field;

use Framework\Field\StringField;

class PasswordField extends StringField
{
    const TYPE = "password";

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        unset($this->value);
    }
}
