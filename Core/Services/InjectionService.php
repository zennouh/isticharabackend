<?php

namespace Core\Services;

use ReflectionClass;

class InjectionService
{
    static function inject(string $class)
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();
        $dependencies  = [];
        foreach ($params as $param) {
            $type = $param->getType();
            $className = $type->getName();
            $classReflection = new ReflectionClass($className);
            $object = $classReflection->newInstance();
            $dependencies[] = $object;
        }
        return $reflection->newInstanceArgs($dependencies);
    }
}
