<?php

namespace App\Core\Router;

use App\Core\App;
use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use ReflectionClass;

class Router
{
    public   function dispach(): ?array
    {
        $scannedRoute = $this->scan("../App/Controllers/*.php");
        // var_dump($scannedRoute);
        $actions = $this->match($scannedRoute);
        return $actions;
    }

    public  function scan(string $path): array
    {
        $routes = [];
        $allFiles = glob($path);

        foreach ($allFiles as $class) {
            $class = str_replace(["/", ".php", "..\\"], ["\\", "", ""], $class);
            $reflection = new ReflectionClass($class);

            $classMethods = $reflection->getMethods();

            foreach ($classMethods as $method) {
                $routeAttr = $method->getAttributes(Route::class)[0] ?? null;

                if (!$routeAttr) {
                    continue;
                }
                $argsArray = $routeAttr->getArguments();



                $routes[] = [
                    "path" => $argsArray[0],
                    "httpMethod" => $argsArray[1],
                    "class" => $class,
                    "method" => $method->getName(),
                ];
            }
        }
        return $routes;
    }

    public   function match(array $routes): ?array
    {

        $request = App::getContainer()->resolve(Request::class);
        foreach ($routes as $route) {
            $method = $request->getMethod();
            if ($method !== $route["httpMethod"]) {
                continue;
            }
            $uri = $request->getUri();
            $pattern = "#^" . preg_replace('/\{[^}]+\}/', '([^/]+)', $route["path"]) . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return [
                    "params" => $matches,
                    "httpMethod" => $method,
                    "class" => $route["class"],
                    "method" => $route["method"],
                ];
            }
        }
        return null;
    }
}
