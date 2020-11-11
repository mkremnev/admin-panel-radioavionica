<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('{}');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();

