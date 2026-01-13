<?php

namespace App\Core;

use App\Core\Services\Container;

class App
{
    protected static Container $container;

    static function   setContainer(Container $container)
    {
        self::$container = $container;
    }
    static  function  getContainer()
    {
        return self::$container;
    }
}
