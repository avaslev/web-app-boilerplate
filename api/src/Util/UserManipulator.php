<?php


namespace App\Util;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManipulator
{
    /**
     * @var UserRepository
     */
    private $entityRepository;
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(UserRepository $entityRepository, EncoderFactoryInterface $encoderFactory)
    {
        $this->entityRepository = $entityRepository;
        $this->encoderFactory = $encoderFactory;
    }

    public function create(string $email, string $password): void
    {
        $user = new User();
        $encoder = $this->encoderFactory->getEncoder($user);
        $user
            ->setEmail($email)
            ->setPassword($encoder->encodePassword($password, null));

        $this->entityRepository->save($user);
    }
}
