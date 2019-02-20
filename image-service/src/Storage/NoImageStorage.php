<?php


namespace App\Storage;


class NoImageStorage implements StorageInterface, ProducibleInterface, DeletableInterface, SavableInterface
{
    /**
     * @var string
     */
    private $mediaUrl;

    public function __construct(string $mediaUrl)
    {
        $this->mediaUrl = $mediaUrl;
    }

    public function delete(string $mediaName): bool
    {
        $this->support($mediaName);
        return true;
    }

    public function produce(string $name): string
    {
        return $this->mediaUrl;
    }

    public function save(string $file): string
    {
        $this->support($file);
        return $this->mediaUrl;
    }

    private function support(string $mediaName)
    {
        if ($mediaName !== $this->mediaUrl) {
            throw new \InvalidArgumentException('This file not support');
        }
    }

}
