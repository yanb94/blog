<?php

namespace Framework;

class Route
{
    protected $name;

    protected $url;
    protected $module;
    protected $controller;
    protected $action;

    protected $vars = [];
    protected $validateVars = [];
    protected $rightAccess;

    public function match(string $url)
    {
        if ($this->hasVars()) {
            $validateVars = $this->validateVars;

            $urlControl = preg_replace_callback(
                "/(\{{1}[A-Za-z0-9]{1,}\}{1})/",
                function ($matches) use (&$validateVars) {
                    return array_shift($validateVars);
                },
                $this->url
            );

            if (preg_match("#".$urlControl."#", $url, $vars)) {
                $i = 0;
                foreach ($this->validateVars as $key => $value) {
                    $this->vars[$key] = $vars[$i + 1];

                    $i++;
                }

                return true;
            }
        } else {
            if ($url == $this->url) {
                return true;
            }
        }

        return false;
    }

    public function generateUrl(): string
    {
        if ($this->hasVars()) {
            $validateVars = $this->validateVars;
            $vars = $this->vars;

            $urlControl = preg_replace_callback(
                "/(\{{1}[A-Za-z0-9]{1,}\}{1})/",
                function ($matches) use (&$validateVars) {
                    return array_shift($validateVars);
                },
                $this->url
            );

            $urlReturn = preg_replace_callback(
                "/(\{{1}[A-Za-z0-9]{1,}\}{1})/",
                function ($matches) use (&$vars) {
                    return array_shift($vars);
                },
                $this->url
            );

            if (preg_match("#".$urlControl."#", $urlReturn)) {
                return $urlReturn;
            } else {
                throw new \Exception("Parameters of route are incorrect", 1);
            }
        } else {
            return $this->url;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getVar(string $key): string
    {
        return $this->vars[$key];
    }

    public function addVar(string $key, string $value): self
    {
        $this->vars[$key] = $value;

        return $this;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function setVars(array $vars): self
    {
        $this->vars = $vars;

        return $this;
    }

    public function getValidateVar(string $key): string
    {
        return $this->vars[$key];
    }

    public function addValidateVar(string $key, string $value): self
    {
        $this->validateVars[$key] = "(".$value.")";

        return $this;
    }

    public function setValidateVars(array $validateVars): self
    {
        $this->validateVars = $vars;

        return $this;
    }

    public function getRightAccess()
    {
        return $this->rightAccess;
    }

    public function setRightAccess($rightAccess): self
    {
        $this->rightAccess = $rightAccess;

        return $this;
    }

    public function hasVars(): bool
    {
        return !empty($this->validateVars);
    }
}
