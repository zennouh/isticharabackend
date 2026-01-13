<?php



use App\Core\Services\Container;
use App\Core\App;
use App\Core\Http\Request;
use App\Core\Http\Response;
 

$container = new Container();

$container->bind(Request::class, fn() => new Request());

$container->bind(Response::class, fn() => new Response());

App::setContainer($container);