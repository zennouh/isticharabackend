<?php
require_once '../vendor/autoload.php';
require_once "../App/Core/bootstrap.php";

use Core\Kernel;

try {

    $kernel = new Kernel();
    $kernel->handler();
} catch (Throwable $e) {

    
    echo $e->getTraceAsString() . "<br>";
    
}
