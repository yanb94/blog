<?php
namespace Framework;

use Framework\Request;
use Framework\User;
use Framework\Config;
use Framework\Router;

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
        $this->router = new Router($this, __DIR__."/../config/router.xml");
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
        try {
            $route = $this->router->getRoute($this->request->requestURI());
            $module = $route->getModule();
            $controller = $route->getController();


            $controller = 'Application\\'.$module.'Module\\Controller\\'.$controller.'Controller';
            $action = $route->getAction();

            if ($route->hasVars()) {
                (new $controller($this))->$action($route->getVars())->send();
            } else {
                (new $controller($this))->$action()->send();
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
