<?php 
namespace Framework;

use Framework\App;

abstract class AppComponent
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function getApp():App
    {
        return $this->app;
    }
}
