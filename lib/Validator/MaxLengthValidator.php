<?php

namespace Framework\Validator;

use Framework\Validator;

class MaxLengthValidator extends Validator
{
    protected $maxLength;

    public function __construct(string $errorMessage, int $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value): bool
    {
        return strlen($value) <= $this->maxLength;
    }

    public function setMaxLength(int $maxLength)
    {
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        } else {
            throw new \Exception("Max length must be superior than zero", 1);
        }
    }

    public function getMaxLenght(): int
    {
        return $this->maxLength;
    }
}
