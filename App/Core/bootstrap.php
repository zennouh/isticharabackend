<?php



use App\Core\Services\Container;
use App\Core\App;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\MyEntityManager;
use Doctrine\ORM\EntityManagerInterface;

$container = new Container();

$container->bind(Request::class, fn() => new Request());

$container->bind(Response::class, fn() => new Response());

// $container->bind(EntityManagerInterface::class, fn() => new MyEntityManager());

App::setContainer($container);