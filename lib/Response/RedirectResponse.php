<?php

namespace Framework\Response;

use Framework\Response;

class RedirectResponse extends Response
{
    protected $url;

    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    protected function redirect(string $url)
    {
        header('Location: '.$url);
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function send()
    {
        $this->redirect($this->url);
        exit;
    }
}
