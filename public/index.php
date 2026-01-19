<?php
require_once '../vendor/autoload.php';
require_once "../App/Core/bootstrap.php";

use App\Core\Kernel;
use App\Core\Services\JsonResponse;
use App\Core\Services\LoggerService;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


set_error_handler(function (
    $err_severity,
    $err_msg,
    $err_file,
    $err_line,
    $err_context
) {
    //     set_exception_handler(function (Throwable $e) use ($logger) {
    //     $logger->error('Unhandled Exception', [
    //         'message' => $e->getMessage(),
    //         'file' => $e->getFile(),
    //         'line' => $e->getLine(),
    //         'code' => $e->getCode(),
    //     ]);

    //     http_response_code(500);
    //     echo json_encode([
    //         'success' => false,
    //         'message' => 'Internal Server Error'
    //     ]);
    // });

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

    LoggerService::getInstance()
        ->error($e);

    $response  = new JsonResponse([
        'success' => false,
        'errno' =>  $e->getCode(),
        'message' => $e->getMessage(),
        'track' => $e->getTraceAsString(),
    ], 500);

    $response->send();
}
