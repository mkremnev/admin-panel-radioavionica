<?php
/**
 * @author Maxim Kremnev <m.kremnev@netlinux.ru>
 * @var ContainerInterface $container
 * @var App $app
 */

declare(strict_types=1);

namespace App;
use Psr\Container\ContainerInterface;
use Slim\App;

http_response_code(500);

require __DIR__ . '/vendor/autoload.php';

$container = require __DIR__ . '/config/container.php';

$app = (require __DIR__ . '/config/app.php')($container);

$app->run();
