<?php


namespace App\Core\Http;

class Response
{

    static function redirect($location, $statusCode  = 200)
    {
        http_response_code($statusCode);
        header("location: $location");
        exit;
    }
}
