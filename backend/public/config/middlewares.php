<?php

declare(strict_types=1);

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $container): void {
    $app->addRoutingMiddleware();
    /**
     * @psalm-var array{debug: bool}
     * @psalm-var array{env: string}
     */
    $config = $container->get('config');
    $app->addErrorMiddleware($config['debug'] ?? true, $config['env'] !== 'test', true);
};
