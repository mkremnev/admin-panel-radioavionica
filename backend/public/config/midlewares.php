<?php

declare(strict_types=1);

use Slim\App;
use Psr\Container\ContainerInterface;

return static function (App $app, ContainerInterface $continer): void
{
  $app->addRoutingMiddleware();
  $app->addErrorMiddleware($continer->get('config')['debug'], true, true);
};
