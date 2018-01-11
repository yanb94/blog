<?php

namespace Framework;

abstract class Manager
{
    protected $dao;

    public function __construct(\PDO $dao)
    {
        $this->dao = $dao;
    }
}
