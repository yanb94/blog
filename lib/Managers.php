<?php

namespace Framework;

class Managers
{
    protected $dao;
    protected $managers;

    public function __construct(\PDO $dao)
    {
        $this->dao = $dao;
    }

    public function getManagerOf(string $entity)
    {
        if (!isset($this->managers[$entity])) {
            $manager = "Framework\\Manager\\".$entity.'Manager';

            if (class_exists($manager)) {
                $this->managers[$entity] = new $manager($this->dao);
            } else {
                throw new \Exception("This managers does not exist", 1);
            }
        }

        return $this->managers[$entity];
    }
}
