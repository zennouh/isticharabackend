<?php

namespace App\Core\Services;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Throwable;

class LoggerService
{
    private static ?LoggerService $instance = null;
    private Logger $logger;


    private function __construct()
    {
        $this->logger = new Logger('app');

        $logPath = dirname(__DIR__, 3) . '/logs/app.log';

        $this->logger->pushHandler(
            new StreamHandler($logPath, Logger::DEBUG)
        );
    }


    public static function getInstance(): LoggerService
    {
        if (self::$instance === null) {
            self::$instance = new LoggerService();
        }

        return self::$instance;
    }


    public function error(Throwable $e): void
    {
        $this->logger->error($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }


    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }


    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }


    public function getLogger(): Logger
    {
        return $this->logger;
    }
}
