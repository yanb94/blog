<?php

namespace Framework;

use Framework\AppComponent;
use Framework\Route;
use Framework\Exception\PageNotFoundException;
use Framework\Exception\AccessDeniedException;

class Router extends AppComponent
{
    protected $routes = [];
    protected $masterRouter;


    public function __construct(App $app, string $masterRouterUrl)
    {
        parent::__construct($app);
        $this->setMasterRouter($masterRouterUrl);
        $this->load();
    }


    protected function load()
    {
        $masterRouter = simplexml_load_file($this->masterRouter);

        foreach ($masterRouter->{'master-router'}->module as $module) {
            $moduleName = $module['name'];
            $modulePrefix = isset($module['prefix']) ? $module['prefix'] : "";
            $moduleRole = isset($module['role']) ? $module['role'] : null;

            $routerModule = simplexml_load_file(__DIR__."/../src/".$moduleName."Module/config/router.xml");

            foreach ($routerModule->routes->route as $routeConfig) {
                $routeNew = new Route();

                $routeAccess = isset($routeConfig['role'])? $routeConfig['role'] : $moduleRole;

                $routeNew
                    ->setName($routeConfig['name'])
                    ->setUrl($modulePrefix.$routeConfig['url'])
                    ->setModule($moduleName)
                    ->setController($routeConfig['controller'])
                    ->setAction($routeConfig['action'])
                    ->setRightAccess($routeAccess);


                if (count($routeConfig->param) > 0) {
                    foreach ($routeConfig->param as $param) {
                        $routeNew->addValidateVar($param['name'], $param['requirement']);
                    }
                }

                $this->addRoute($routeNew);
            }
        }
    }

    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    public function getRoute(string $url): Route
    {
        foreach ($this->routes as $route) {
            if ($route->match($url)) {
                if (is_null($route->getRightAccess()) || $this->app->getUser()->isGranted($route->getRightAccess())) {
                    return $route;
                } else {
                    throw new AccessDeniedException("Access denied", 403);
                }
            }
        }

        throw new PageNotFoundException("Page not found", 404);
    }

    public function generateUrl(string $name, array $params = [])
    {
        $url = $this->routes[$name]->setVars($params)->generateUrl();

        return $url;
    }

    public function setMasterRouter(string $masterRouterUrl)
    {
        $this->masterRouter = $masterRouterUrl;
    }
}
