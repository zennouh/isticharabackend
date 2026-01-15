<?php

namespace App\Core\Services;

 
use ReflectionClass;

class InjectionService
{
    static function inject(string $class): object
    {
        // avocta controller
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        // var_dump($constructor);
        if (!$constructor) {
            return $reflection->newInstance();;
        }
        $params = $constructor->getParameters();

        // var_dump($params);
        $dependencies  = [];
        foreach ($params as $param) {
            $type = $param->getType();
            $className = $type->getName(); // repo
            // echo $className;
            $classReflection = new ReflectionClass($className);
            // echo "<br>" . "iurgeuiq"  . "<br>"; 
            $object = $classReflection->newInstance();
            $dependencies[] = $object;
        }
        return $reflection->newInstanceArgs($dependencies);
    }
}
