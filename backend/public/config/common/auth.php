<?php

declare(strict_types=1);

use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\Tokenizer;
use App\Security\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => function (ContainerInterface $container): UserRepository {
        $em = $container->get(EntityManagerInterface::class);
        /**
         * @var EntityRepository $repo
         * @psalm-var EntityRepository<User> $repo
         */
        $repo = $em->getRepository(User::class);
        return new UserRepository($em, $repo);
    },

    Tokenizer::class => function (ContainerInterface $container): Tokenizer {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{token_ttl:string} $config
         */
        $config = $container->get('config')['auth'];
        return new Tokenizer(new DateInterval($config['token_ttl']));
    },
    //TODO вынести в отдельный конфиг
    SessionManager::class => function (ContainerInterface $container): SessionManager {
        $config = $container->get('config')['session'];

        return new SessionManager($config['lifetime'], $config['name']);
    },

    'config' => [
        'auth' => [
            'token_ttl' => 'PT1H'
        ],
        'session' => [
            'lifetime' => '100',
            'name' => 'test'
        ]
    ]
];
