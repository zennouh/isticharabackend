<?php

namespace App\Core\Http;

use App\Core\Services\ObjectMapper as ServicesObjectMapper;
use ObjectMapper;

class Request

{

    public function getMethod()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $__methodIsSet = isset($_POST["__method"]);
        if ($method == "POST" && $__methodIsSet) {
            return $_POST["__method"];
        }
        return $_SERVER["REQUEST_METHOD"];
    }

    public function getUri()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function getQueryParams()
    {
        $query = parse_url($_SERVER["REQUEST_URI"])["query"];
        return $query;
    }

    public function getPostParams(string $className): object
    {
        $json_data = file_get_contents('php://input');

        $data = json_decode($json_data, true);

        return  ServicesObjectMapper::toObject($className, $data);
    }
    public function bodyParam(): array
    {
        $json_data = file_get_contents('php://input');

        $data = json_decode($json_data, true);

        return  $data;
    }
}
