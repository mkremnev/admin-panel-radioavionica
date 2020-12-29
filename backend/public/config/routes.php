<?php

declare(strict_types=1);

use Slim\App;
use App\Http;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);

    $app->group('/v1', function (RouteCollectorProxy $group): void {
        $group->group('/auth', function (RouteCollectorProxy $group): void {
            $group->post('/join', Action\v1\Auth\Join\RequestAction::class);
            $group->post('/join/confirm', Action\v1\Auth\Join\ConfirmAction::class);
        });
    });
};
