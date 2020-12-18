<?php

declare(strict_types=1);

namespace App\Console;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesLoadCommand extends Command
{
    private EntityManagerInterface $em;

    /** @var array string */
    private array $path;

    public function __construct(EntityManagerInterface $em, array $path)
    {
        parent::__construct();
        $this->em = $em;
        $this->path = $path;
    }

    protected function configure(): void
    {
        $this->setName('fixtures:load')->setDescription('Load Fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Loading fixtures</comment>');

        $loader = new Loader();

        foreach ($this->path as $path) {
            $loader->loadFromDirectory($path);
        }

        $executor = new ORMExecutor($this->em, new ORMPurger());

        $executor->setLogger(static function (string $message) use ($output) {
            $output->writeln($message);
        });

        $executor->execute($loader->getFixtures());

        $output->writeln('<comment>Done!</comment>');

        return 0;
    }
}
