<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Create a User.',
)]
class CreateUserCommand extends Command
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('login', InputArgument::REQUIRED, 'Login.')
            ->addArgument('password', InputArgument::REQUIRED, 'Password.')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'Admin')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();
        $user->setLogin($input->getArgument('login'));

        if (null !== $this->userRepository->findOneBylogin($user->getLogin())) {

            $io->error('User already exists');

            return  Command::FAILURE;

        } else {

            if ($input->getOption('admin')) {
                $user->addRole('ROLE_ADMIN');
            }

            $user->setPassword($this->userPasswordHasher->hashPassword($user, $input->getArgument('password')));

            $this->userRepository->add($user, true);

            $io->success('User Created.');

            return Command::SUCCESS;

        }
    }
}
