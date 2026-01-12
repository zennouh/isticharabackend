<?php

namespace Core\Http;

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

    public function getPostParams(): array
    {
        return $_POST;
    }

    // public function getGetParamsAsObj(string $className): object
    // {
    //     $params = ObjectMapper::arrayToObject($className, $_GET);

    //     return $params;
    // }
}
