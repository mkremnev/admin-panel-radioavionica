<?php

declare(strict_types=1);

use App\UploadHandler\UploadHandler;
use Psr\Container\ContainerInterface;

return [
    UploadHandler::class => function (ContainerInterface $container): UploadHandler {
        $config = $container->get('config');

        return new UploadHandler($config['upload_dir']);
    },

    'config' => [
        'upload_dir' => '/app/public/var',
    ]
];
