<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Product;
use App\Message\ContextMediaMessage;
use App\Message\MediaMessage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    private const ACTION_MEDIA_PRODUCE = 'action_media_produce';
    private const ACTION_MEDIA_DELETE = 'action_media_delete';

    /**
     * @var UnitOfWork
     */
    private $unitOfWork;
    /**
     * @var ProducerInterface
     */
    private $producer;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, ProducerInterface $producer, SerializerInterface $serializer)
    {
        $this->unitOfWork = $entityManager->getUnitOfWork();
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['handleChanges', EventPriorities::PRE_WRITE],
                ['postUpdate', EventPriorities::POST_WRITE],
            ],
        ];
    }

    public function postUpdate(GetResponseForControllerResultEvent $event)
    {
        /** @var Product $product */
        $product = $event->getControllerResult();

        if ($event->getRequest()->attributes->get(self::ACTION_MEDIA_PRODUCE)) {
            $context = new ContextMediaMessage($product->getId(), Product::class);
            $message = new MediaMessage(MediaMessage::ACTION_PRODUCE, '', $product->getName(), $context);
            $this->producer->publish($this->serializer->serialize($message, 'json'), 'media.' . $message->getAction());
        }

        if ($event->getRequest()->attributes->get(self::ACTION_MEDIA_DELETE)) {
            $context = new ContextMediaMessage($product->getId(), Product::class);
            $message = new MediaMessage(MediaMessage::ACTION_DELETE, $product->getMedia(), '', $context);
            $this->producer->publish($this->serializer->serialize($message, 'json'), 'media.' . $message->getAction());
        }
    }

    public function handleChanges(GetResponseForControllerResultEvent $event)
    {
        $product = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$product instanceof Product || !in_array($method, [Request::METHOD_POST, Request::METHOD_PUT])) {
            return;
        }

        $this->unitOfWork->computeChangeSets();
        $changeSet = $this->unitOfWork->getEntityChangeSet($product);
        if (isset($changeSet['name']) || !$product->getId()) {
            $event->getRequest()->attributes->set(self::ACTION_MEDIA_PRODUCE, true);
            $event->getRequest()->attributes->set(self::ACTION_MEDIA_DELETE, (bool) $product->getMedia());
        }

    }
}
