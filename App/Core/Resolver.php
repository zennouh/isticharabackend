<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Services\InjectionService;

use ReflectionMethod;

class Resolver
{


    public function resolve(array $action)
    {
        $request = App::getContainer()->resolve(Request::class);
        $middlewares = $action["middlewares"] ?? [];

        // var_dump($middlewares);



        foreach ($middlewares as $md) {
            // var_dump($md);
            $md->handle($request);
        }


        $controller = InjectionService::inject($action['class']);

        $reflection  = new ReflectionMethod($controller, $action['method']);
        $dependencies = [];

        foreach ($reflection->getParameters() as $param) {
            $type = $param->getType();
            if ($type && $type->getName() === Request::class) {

                $dependencies[] = App::getContainer()->resolve(Request::class);
            } elseif ($type && $type->getName() === Response::class) {

                $dependencies[] = App::getContainer()->resolve(Response::class);
            } elseif (!empty($action['params'])) {

                $dependencies[] = array_shift($action['params']);
            }
        }


        return $reflection->invokeArgs($controller, $dependencies);
    }
}
