<?php

namespace App\Command;

use App\Entity\User;
use App\Utils\DummyUserCreator;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateDummyUsersCommand extends Command
{
    protected static $defaultName = 'app:create-dummy-users';
    protected static $defaultDescription = 'Add a list of dummy users for dev environment';
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'total',
                InputArgument::OPTIONAL,
                'Total of users to create'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $totalUser = $input->getArgument('total');

        if (!$totalUser) {
            $totalUser = 20;
        }

        $dummyUserCreator = new DummyUserCreator($this->entityManager);

        $result = $dummyUserCreator->create($totalUser);

        if ($result === true) {
            $io->success(sprintf('You have created %d dummy users', $totalUser));
        } else {
            $io->warning(sprintf('Error in creation of dummy Users'));
        }

        return Command::SUCCESS;
    }
}
