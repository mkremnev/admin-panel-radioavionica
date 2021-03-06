<?php

declare(strict_types=1);

use App\Frontend\FrontendUrlTwigExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;

return [
    Environment::class => function (ContainerInterface $container): Environment {
        $config = $container->get('config')['twig'];

        $loader = new FilesystemLoader();

        foreach ($config['templates_dir'] as $alias => $path) {
            $loader->addPath($path, $alias);
        }

        $environment = new Environment($loader, [
            'cache' => $config['debug'] ? false : $config['cache_dir'],
            'debug' => $config['debug'],
            'strict_variables' => $config['debug'],
            'auto_reload' => $config['debug']
        ]);

        if ($config['debug']) {
            $environment->addExtension(new DebugExtension());
        }

        foreach ($config['extensions'] as $class) {
            /** @var ExtensionInterface $extension */
            $extension = $container->get($class);
            $environment->addExtension($extension);
        }

        return $environment;
    },
    'config' => [
        'twig' => [
            'cache_dir' => __DIR__ . '/../../var/cache/twig',
            'templates_dir' => [
                FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../../templates'
            ],
            'debug' => (bool)getenv('APP_DEBUG'),
            'extensions' => [
                FrontendUrlTwigExtension::class,
            ],
        ]
    ]
];
