<?php
require_once '../vendor/autoload.php';
require_once "../App/Core/bootstrap.php";

use App\Core\Kernel;
use App\Core\Services\JsonResponse;


set_error_handler(function (
    $err_severity,
    $err_msg,
    $err_file,
    $err_line,
    $err_context
) {
    throw new ErrorException(
        $err_msg,
        500,
        $err_severity,
        filename: $err_file,
        line: $err_line
    );
});


try {

    $kernel = new Kernel();
    $kernel->handler();
} catch (Throwable $e) {
 

    $response  = new JsonResponse([
        'success' => false,
        'errno'=>  $e->getCode(),
        'message' => $e->getMessage(),
        'track' => $e->getTraceAsString(),
    ], 500);

    $response->send();
}
