<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class AuthSubscriber
 * @package App\EventSubscriber
 */
class AuthSubscriber implements EventSubscriberInterface
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onLexikJwtAuthenticationOnAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $data = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];
        $event->setData(array_merge($event->getData(), $data));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onLexikJwtAuthenticationOnAuthenticationSuccess',
        ];
    }
}
