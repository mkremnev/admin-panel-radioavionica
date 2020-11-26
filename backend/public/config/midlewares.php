<?php

declare(strict_types=1);

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $continer): void {
    $app->addRoutingMiddleware();
    /** @psalm-var array{debug: bool} */
    $config = $continer->get('config');
    $app->addErrorMiddleware($config['debug'], true, true);
};
