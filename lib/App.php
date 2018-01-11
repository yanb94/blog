<?php
namespace Framework;

use Framework\Request;
use Framework\User;
use Framework\Config;

class App
{
    protected $request;
    protected $user;
    protected $config;
    protected $router;

    public function __construct()
    {
        $this->request = new Request();
        $this->user = new User($this);
        $this->config = new Config(__DIR__."/../config/config.xml");
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getConfig()
    {
        return $this->config->getConfig();
    }

    public function run()
    {
    }
}
