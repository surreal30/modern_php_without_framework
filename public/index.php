<?php

declare(strict_types=1);

require_once dirname(__DIR__) . "/vendor/autoload.php";

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAttributes(false);
$containerBuilder->addDefinitions([
	\NoFrameworkApp\HelloWorld::class => \DI\create(\NoFrameworkApp\HelloWorld::class)
]);

$container = $containerBuilder->build();

$helloWorld  = $container->get(\NoFrameworkApp\HelloWorld::class);
$helloWorld->announce();