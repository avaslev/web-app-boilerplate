<?php

namespace App\Command;

use App\Util\UserManipulator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ApiUserCreateCommand
 * @package App\Command
 */
class ApiUserCreateCommand extends Command
{
    const ARGUMENT_EMAIL = 'email';
    const ARGUMENT_PASSWORD = 'password';

    /**
     * @var string
     */
    protected static $defaultName = 'api:user:create';
    /**
     * @var UserManipulator
     */
    private $userManipulator;

    /**
     * ApiUserCreateCommand constructor.
     */
    public function __construct(UserManipulator $userManipulator)
    {
        $this->userManipulator = $userManipulator;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->setDefinition(array(
                new InputArgument(self::ARGUMENT_EMAIL, InputArgument::REQUIRED, 'The email'),
                new InputArgument(self::ARGUMENT_PASSWORD, InputArgument::REQUIRED, 'The password'),
            ))
            ->setHelp(<<<'EOT'
The <info>api:user:create</info> command creates a user:
  <info>php %command.full_name% any@user.ru anypass</info>
EOT
            );;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->userManipulator->create(
            $input->getArgument(self::ARGUMENT_EMAIL),
            $input->getArgument(self::ARGUMENT_PASSWORD)
        );


        $io->success(sprintf('User %s created!', $input->getArgument(self::ARGUMENT_EMAIL)));
    }
}
