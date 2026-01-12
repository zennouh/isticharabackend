<?php

namespace Core;

use Core\Router\Router;

class Kernel
{
    public function handler()
    {

        session_start();

        $route = new Router();
        
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
