<?php


namespace App\Consumer;


use App\Message\MediaMessage;
use App\Service\MediaService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;

class MediaConsumer implements ConsumerInterface
{

    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var MediaService
     */
    private $mediaService;


    /**
     * @var ProducerInterface
     */
    private $producer;

    public function __construct(SerializerInterface $serializer, MediaService $mediaService)
    {
        $this->serializer = $serializer;
        $this->mediaService = $mediaService;
    }

    public function setProducer (ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    public function execute(AMQPMessage $msg)
    {
        /** @var MediaMessage $mediaMessage */
        $mediaMessage = $this->serializer->deserialize($msg->getBody(), MediaMessage::class, 'json');
        switch ($mediaMessage->getAction()) {
            case MediaMessage::ACTION_PRODUCE:
                $mediaMessage->setMedia($this->mediaService->create($mediaMessage->getQuery()));
                break;
            case MediaMessage::ACTION_DELETE:
                $this->mediaService->delete($mediaMessage->getMedia());
                break;
        }

        $this->producer->publish(
            $this->serializer->serialize($mediaMessage, 'json'),
            'api.media.' . $mediaMessage->getAction()
        );
    }

}
