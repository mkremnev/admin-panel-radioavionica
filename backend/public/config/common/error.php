<?php

declare(strict_types=1);

use App\ErrorHandler\LogErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
    ErrorMiddleware::class => function (ContainerInterface $container): ErrorMiddleware {
        $callableResolver = $container->get(CallableResolverInterface::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{display_details:bool} $config
         */
        $config = $container->get('config')['error'];

        $middleware = new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_details'],
            true,
            true
        );

        $logger = $container->get(LoggerInterface::class);

        $middleware->setDefaultErrorHandler(
            new LogErrorHandler($callableResolver, $responseFactory, $logger)
        );

        return $middleware;
    },

    'config' => [
        'error' => [
            'display_details' => (bool)getenv('APP_DEBUG'),
            'log' => true
        ]
    ],
];
