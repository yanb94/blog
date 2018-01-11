<?php

namespace Framework\Validator;

use Framework\Validator;

class MinLengthValidator extends Validator
{
    protected $minLength;

    public function __construct(string $errorMessage, int $minLength)
    {
        parent::__construct($errorMessage);

        $this->setMinLength($minLength);
    }

    public function isValid($value): bool
    {
        return strlen($value) >= $this->minLength;
    }

    public function setMinLength(int $minLength)
    {
        if ($minLength > 0) {
            $this->minLength = $minLength;
        } else {
            throw new \Exception("Min length must be superior than zero", 1);
        }
    }

    public function getMaxLenght(): int
    {
        return $this->minLength;
    }
}
