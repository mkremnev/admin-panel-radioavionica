<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\Migrations;

return [
    'config' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
                UpdateCommand::class,

                Migrations\Tools\Console\Command\ExecuteCommand::class,
                Migrations\Tools\Console\Command\DumpSchemaCommand::class,
                Migrations\Tools\Console\Command\MigrateCommand::class,
                Migrations\Tools\Console\Command\LatestCommand::class,
                Migrations\Tools\Console\Command\ListCommand::class,
                Migrations\Tools\Console\Command\StatusCommand::class,
                Migrations\Tools\Console\Command\UpToDateCommand::class,
            ],
        ]
    ]
];
