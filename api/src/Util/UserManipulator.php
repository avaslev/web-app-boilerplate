<?php


namespace App\Util;


use App\Entity\User;
use App\Repository\UserRepository;

class UserManipulator
{
    /**
     * @var UserRepository
     */
    private $entityRepository;

    public function __construct(UserRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function create(string $email, string $password): void
    {
        $user = new User();
        $user
            ->setEmail($email)
            ->setPassword($this->passwordHash($password))
        ;

        $this->entityRepository->save($user);
    }

    public function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }
}