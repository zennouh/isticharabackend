<?php

namespace App\Core\Middleware;

use App\Core\Http\Response;
use App\Core\Http\Request;

use App\Core\Middleware\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        header("Access-Control-Allow-Origin: http://localhost:5174");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");
        // Access-Control-Allow-Credentials: true

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }
}
