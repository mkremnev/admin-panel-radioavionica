<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use App\Console\MailerCheckCommand;
use Doctrine\Migrations;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => static function (ContainerInterface $container) {

        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{fixtures_path:string[]}  $config
         */
        $config = $container->get('config')['console'];

        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        return new FixturesLoadCommand(
            $em,
            $config['fixtures_path'],
        );
    },
    'config' => [
        'console' => [
            'commands' => [
                FixturesLoadCommand::class,

                SchemaTool\CreateCommand::class,
                SchemaTool\DropCommand::class,
                MailerCheckCommand::class,
                Migrations\Tools\Console\Command\DiffCommand::class,
                Migrations\Tools\Console\Command\GenerateCommand::class,
            ],
            'fixtures_path' => [
                __DIR__ . '/../../src/Auth/Fixtures',
                __DIR__ . '/../../src/Military/Fixtures',
            ]
        ]
    ]
];
