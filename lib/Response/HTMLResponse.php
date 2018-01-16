<?php

namespace Framework\Response;

use Framework\Response;

class HTMLResponse extends Response
{
    protected $body;

    public function __construct(string $body)
    {
        $this->setBody($body);
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function send()
    {
        echo($this->body);
    }
}
