<?php

declare(strict_types=1);

namespace NoFrameworkApp;

class HelloWorld
{
	public function __invoke(): void
	{
		echo "Hello, autoload world";
		exit();
	}
}