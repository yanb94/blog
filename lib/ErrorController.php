<?php

namespace Framework;

use Framework\Controller;

class ErrorController extends Controller
{
    public function error404()
    {
        return $this->render("@core/error404.html.twig");
    }

    public function error403()
    {
        return $this->render("@core/error403.html.twig");
    }
}
