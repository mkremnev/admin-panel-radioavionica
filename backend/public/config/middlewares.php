<?php

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use App\Http\Middleware;

return static function (App $app): void {
    (getenv('APP_ENV') !== 'test' ? $app->add(Middleware\SessionMiddleware::class) : null);
    $app->add(Middleware\ValidationExceptionHandler::class);
    $app->add(Middleware\DomainExceptionHandler::class);
    $app->add(Middleware\ClearEmptyInput::class);
    $app->add(Middleware\TranslationLocale::class);
    $app->add(Middlewares\ContentLanguage::class);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(ErrorMiddleware::class);
};
