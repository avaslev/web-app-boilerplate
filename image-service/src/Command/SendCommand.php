<?php

namespace App\Command;

use App\Message\MediaMessage;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SendCommand extends Command
{
    protected static $defaultName = 'media:produce';

    private SerializerInterface $serializer;
    private ProducerInterface $producer;

    public function __construct(SerializerInterface $serializer, ProducerInterface $producer)
    {
        parent::__construct();
        $this->serializer = $serializer;
        $this->producer = $producer;
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

        $mediaMessage = new MediaMessage(MediaMessage::ACTION_PRODUCE);
        $mediaMessage->setQuery($input->getArgument('query'));
        $this->producer->publish($this->serializer->serialize($mediaMessage, 'json'));

        $io->success('ok');

        return self::SUCCESS;
    }
}
