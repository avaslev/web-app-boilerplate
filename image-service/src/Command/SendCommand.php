<?php

namespace App\Command;

use App\Message\MediaMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendCommand extends Command
{
    protected static $defaultName = 'media:produce';
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add message to media queue')
            ->setDefinition(array(
                new InputArgument('query', InputArgument::REQUIRED, 'Name image'),
            ))
            ->setHelp(<<<'EOT'
The <info>media:produce</info> command creates message to queue:
  <info>php %command.full_name% any_query</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $serializer = $this->container->get('serializer');
        $mediaMessage = new MediaMessage(MediaMessage::ACTION_PRODUCE);
        $mediaMessage->setQuery($input->getArgument('query'));
        $this->container->get('old_sound_rabbit_mq.media_producer')->publish($serializer->serialize($mediaMessage, 'json'));


        $io->success('ok');
    }
}
