<?php


namespace App\Consumer;


use App\Entity\Product;
use App\Message\MediaMessage;
use Doctrine\ORM\EntityManagerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;

class MediaConsumer implements ConsumerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var ProducerInterface
     */
    private $producer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ProducerInterface $producer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->producer = $producer;
    }

    public function execute(AMQPMessage $msg)
    {
        /** @var MediaMessage $mediaMessage */
        $mediaMessage = $this->serializer->deserialize($msg->getBody(), MediaMessage::class, 'json');
        if ($mediaMessage->getAction() == MediaMessage::ACTION_PRODUCE) {
            /** @var Product $product */
            $product = $this->entityManager
                ->getRepository($mediaMessage->getContext()->getClass())
                ->findOneById($mediaMessage->getContext()->getId());

            if ($product->getName() == $mediaMessage->getQuery()) {
                $product->setMedia($mediaMessage->getMedia());
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                return;
            }

            $mediaMessage->setAction(MediaMessage::ACTION_DELETE);
            $this->producer->publish($this->serializer->serialize($mediaMessage, 'json'), 'media.' . $mediaMessage->getAction());
        }
    }

}
