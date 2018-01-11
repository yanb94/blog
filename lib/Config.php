<?php

namespace Framework;

class Config
{
    protected $file;
    protected $config;


    public function __construct(string $file)
    {
        $this->setFile($file);
        $this->load();
    }

    public function setFile(string $url)
    {
        $this->file = $url;
    }

    public function setConfig(\SimpleXMLElement $config)
    {
        $this->config = $config;
    }

    protected function load()
    {
        $configXML = simplexml_load_file($this->file);
        $this->setConfig($configXML);
    }

    public function getConfig():\SimpleXMLElement
    {
        return $this->config;
    }
}
