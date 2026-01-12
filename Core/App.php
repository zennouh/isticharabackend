<?php

namespace Core;

use Core\Services\Container;

class App
{
    protected static Container $container;

    static function   setContainer(Container $container)
    {
        static::$container = $container;
    }
    static  function  getContainer()
    {
        return static::$container;
    }
}
