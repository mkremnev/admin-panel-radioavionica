<?php

/**
 * @author Maxim Kremnev <m.kremnev@netlinux.ru>
 * @var ContainerInterface $container
 * @return App $app
 */

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return static function (ContainerInterface $container): App {
    $app = AppFactory::createFromContainer($container);
    (require __DIR__ . '/midlewares.php')($app, $container);
    (require __DIR__ . '/routes.php')($app);
    return $app;
};