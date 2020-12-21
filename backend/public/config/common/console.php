<?php

declare(strict_types=1);

use App\Console;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command;

return [
    'config' => [
        'console' => [
            'commands' => [
                Console\FixturesLoadCommand::class,
                ValidateSchemaCommand::class,
            ],
            'migrations' => [
                Command\ExecuteCommand::class,
                Command\MigrateCommand::class,
                Command\LatestCommand::class,
                Command\StatusCommand::class,
                Command\UpToDateCommand::class,
            ]
        ]
    ]
];