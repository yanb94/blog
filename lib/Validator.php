<?php

namespace Framework;

abstract class Validator
{
    protected $errorMessage;

    abstract public function isValid($value): bool;

    public function __construct(string $errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }

    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
