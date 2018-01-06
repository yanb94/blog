<?php
namespace Framework;

abstract class Response
{
    abstract public function send();

    public function addHeader(string $header)
    {
        header($header);
    }

    public function setCookie(string $name, $value = '', int $expire = 0, $path = null, $domain = null, bool $secure = false, bool $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
}
