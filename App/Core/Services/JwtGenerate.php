<?php

namespace App\Core\Services;

use Firebase\JWT\JWT;

class JwtGenerate
{
    static function generate(array $data): void
    {
        $secret_key = "azertygysrgfgrefgergfrehgvbregfer";

        if (!$secret_key) {
            throw new \Exception("SECRET_KEY is not set in environment");
        }

        $issuedAt = time();
        $expire = $issuedAt + 600000;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
        ];

        foreach ($data as $key => $value) {
            $payload[$key] = $value;
        }

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        setcookie(
            "access_token",
            $jwt,
            [
                "expires"  => time() + 86400,
                "path"     => "/",
                "domain"   => "localhost",
                "secure"   => true,
                "httponly" => true,
                "samesite" => "None",
            ]
        );
    }
}
