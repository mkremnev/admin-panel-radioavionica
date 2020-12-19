<?php

declare(strict_types=1);

use Slim\App;
use App\Http;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);
};
