<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Doctrine\Migrations\Configuration\Configuration;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$cli = new Application('Console');

/**
 * @var string[] $commands
 * @psalm-suppress MixedArrayAccess
 */

$commands = $container->get('config')['console']['commands'];

/** @var EntityManagerInterface $entityManager */
$entityManager = $container->get(EntityManagerInterface::class);
$connection = $entityManager->getConnection();

$configuration = new Configuration();
$configuration->addMigrationsDirectory("App\Data\Migration", __DIR__ . "/../src/Data/Migration");
$configuration->setCheckDatabasePlatform(false);
$configuration->setAllOrNothing(true);

$storageConfiguration = new TableMetadataStorageConfiguration();
$storageConfiguration->setTableName('doctrine_migration_versions');

$configuration->setMetadataStorageConfiguration($storageConfiguration);

$dependencyFactory = DependencyFactory::fromEntityManager(
    new ExistingConfiguration($configuration),
    new ExistingEntityManager($entityManager)
);

$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');

$migrations = $container->get('config')['console']['migrations'];

foreach ($migrations as $name) {
    $cli->add(new $name($dependencyFactory));
}

foreach ($commands as $name) {
    /** @var Command $command */
    $command = $container->get($name);
    $cli->add($command);
}

$cli->run();
