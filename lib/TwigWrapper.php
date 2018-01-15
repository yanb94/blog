<?php

namespace Framework;

use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \Twig_Filter;

class TwigWrapper
{
    protected $twig;

    public function __construct($folderTemplates)
    {
        $loader = new Twig_Loader_Filesystem();

        foreach ($folderTemplates as $folder) {
            $loader->addPath(dirname(__DIR__).$folder['value'], (string)$folder['name']);
        }

        $twig = new Twig_Environment($loader, array(
            'cache' => '/../web/cache',
            'debug' => true
        ));

        $this->setTwig($twig);
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function setTwig(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function addFilter(string $name, callable $function):self
    {
        $twigFilter = new Twig_Filter($name, $function);

        $this->twig->addFilter($twigFilter);

        return $this;
    }

    public function addGlobal(string $name, $var):self
    {
        $this->twig->addGlobal($name, $var);

        return $this;
    }
}
