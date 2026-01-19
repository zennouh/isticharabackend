<?php


namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Middleware\MiddlewareInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuthMiddleware implements MiddlewareInterface
{

    private array $avoidRoutes = ["/signup", "/login", "/avocatexport"];

    public function handle(Request $request): void
    {
        //  if (in_array($request->getUri(), $this->avoidRoutes)) {
        //     return;
        // }
        // $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : "";

        // if (!$token) {
        //     $this->unauthorized('Authorization header missing');
        // }

        // $jwt = $token;

        if (in_array($request->getUri(), $this->avoidRoutes)) {
            return;
        }

        $header = $request->getHeader("Authorization");
        // var_dump($header);
        if (!$header) {
            $this->unauthorized('Authorization header missing');
        }


        if (!preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $this->unauthorized('Invalid Authorization format');
        }
        $jwt = $matches[1];


        $payload = JWT::decode(
            $jwt,
            new Key("azertygysrgfgrefgergfrehgvbregfer", 'HS256')
        );
        // echo "guer";
        $request->setRole($payload->role ?? "client");
    }

    private function unauthorized(string $message): void
    {
        throw new Exception($message, 401);
    }
}
