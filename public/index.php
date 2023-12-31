<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use NoFrameworkApp\HelloWorld;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\requestHandler;
use Relay\Relay;
use Laminas\Diactoros\ServerRequestFactory;
use function DI\create;
use function FastRoute\SimpleDispatcher;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAttributes(false);
$containerBuilder->addDefinitions([
	HelloWorld::class => create(HelloWorld::class)
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
	$r->get("/hello", HelloWorld::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler();

$requestHandler = new Relay($middlewareQueue);
$requestHandler->handle(ServerRequestFactory::FromGlobals());