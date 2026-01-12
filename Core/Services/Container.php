<?php

namespace Core\Services;


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
            throw new \Exception("We could not find a match bindinds");
        }
        $resolver = $this->binds[$className];
        return call_user_func($resolver);
    }
}
