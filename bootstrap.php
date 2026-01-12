<?php

use Core\App;
use Core\Http\Request;
use Core\Http\Response;
use Core\Services\Container;

$container = new Container();

$container->bind(Request::class, fn() => new Request());
$container->bind(Response::class, fn() => new Response());

// $config["db"] = "mysql";

App::setContainer($container);
