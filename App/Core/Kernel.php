<?php

namespace App\Core;

use App\Core\Middleware\CorsMiddleware;
use App\Core\Middleware\JwtAuthMiddleware;
use App\Core\Router\Router;


class Kernel
{
    public function handler()
    {

        session_start();




        $route = new Router();

        $route->addGlobalMiddleware(new CorsMiddleware());
        $route->addGlobalMiddleware(new JwtAuthMiddleware());
        // $route->addGlobalMiddleware(new CorsMiddleware());



        $action = $route->dispach();

        if (!$action) {

            http_response_code(404);

            echo "No action found";

            exit(1);
        }

        $resolver = new Resolver();

        $resolver->resolve($action);
    }
}
