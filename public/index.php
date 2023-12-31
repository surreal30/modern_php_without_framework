<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use NoFrameworkApp\HelloWorld;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\requestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use function DI\create;
use function FastRoute\SimpleDispatcher;
use function DI\get;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAttributes(false);
$containerBuilder->addDefinitions([
	HelloWorld::class => create(HelloWorld::class)
		->constructor(get('Foo'), get('Response')),
	'Foo' => 'bar',
	'Response' => function() {
		return new Response();
	}
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
	$r->get("/hello", HelloWorld::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::FromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);