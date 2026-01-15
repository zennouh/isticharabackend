<?php

namespace App\Core\Services;


class Container
{
    public static Container $instense;
    private array $binds = [];

    public function bind(string $className, callable  $resolver)
    {
        $this->binds[$className] = $resolver;
    }

    public function resolve(string $className)
    {

        if (!array_key_exists($className, $this->binds)) {
            return null;
        }
        $resolver = $this->binds[$className];
        return call_user_func($resolver);
    }
}
