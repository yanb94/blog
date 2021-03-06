<?php

namespace Framework;

class Request
{
    public function cookieData(string $key)
    {
        return isset($_COOKIE[$key])? $_COOKIE[$key] : null;
    }

    public function cookieExists(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    public function getData(string $key)
    {
        return isset($_GET[$key])? $_GET[$key] : null;
    }

    public function getExists(string $key): bool
    {
        return isset($_GET[$key]);
    }

    public function postData(string $key)
    {
        return isset($_POST[$key])? $_POST[$key] : null;
    }

    public function postExists(string $key): bool
    {
        return isset($_POST[$key]);
    }

    public function method():string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function requestURI():string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }
}
