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
        $group->group('/change', function (RouteCollectorProxy $group): void {
            $group->group('/email', function (RouteCollectorProxy $group): void {
                $group->post('', Action\v1\Auth\Change\Email\RequestAction::class);
                $group->post('/confirm', Action\v1\Auth\Change\Email\ConfirmAction::class);
            });
            $group->post('/password', Action\v1\Auth\Change\Password\ChangePasswordAction::class);
        });
        $group->group('/reset', function (RouteCollectorProxy $group): void {
            $group->post('/password', Action\v1\Auth\Reset\Password\RequestAction::class);
            $group->post('/password/confirm', Action\v1\Auth\Reset\Password\ResetAction::class);
        });
        $group->post('/login', Action\v1\Auth\SignIn\RequestAction::class);
        $group->group('/add', function (RouteCollectorProxy $group): void {
            $group->post('/unit', Action\v1\Military\AddUnit\AddUnitsAction::class);
            $group->post('/defect', Action\v1\Military\AddDefect\AddDefectAction::class);
        });
        $group->group('/units', function (RouteCollectorProxy $group): void {
            $group->get('/all', Action\v1\Military\GetUnits\GetAllUnits::class);
        });
        $group->group('/defects', function (RouteCollectorProxy $group): void {
            $group->get('/all', Action\v1\Military\GetDefects\GetAllDefects::class);
        });
    });
};
