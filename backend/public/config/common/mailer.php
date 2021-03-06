<?php

declare(strict_types=1);

use Finesse\SwiftMailerDefaultsPlugin\SwiftMailerDefaultsPlugin;
use Psr\Container\ContainerInterface;

return [
    Swift_Mailer::class => static function (ContainerInterface $container) {
        /** @psalm-suppress MixedArrayAccess $config */
        $config = $container->get('config')['mailer'];

        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['user'])
            ->setPassword($config['pass'])
            ->setEncryption($config['encrypt']);

        $mailer = new Swift_Mailer($transport);

        $mailer->registerPlugin(new SwiftMailerDefaultsPlugin([
            'from' => $config['from']
        ]));

        return $mailer;
    },

    'config' => [
        'mailer' => [
            'host' => getenv('MAILER_HOST'),
            'port' => getenv('MAILER_PORT'),
            'user' => getenv('MAILER_USER'),
            'pass' => getenv('MAILER_PASS'),
            'encrypt' => getenv('MAILER_ENCRYPT'),
            'from' => [getenv('MAILER_FROM_EMAIL') => "AVION"],
        ]
    ],
];
