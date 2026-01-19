<?php

namespace App\Core\Services;

class JsonResponse
{

    public function __construct(
        private array $data,
        private int $statusCode,
        private string $mode = "dev"
    ) {}

    public function send()
    {
        http_response_code($this->statusCode);
        header("Content-Type: application/json");
        echo json_encode($this->data);
        exit;
    }
}
