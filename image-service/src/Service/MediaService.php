<?php


namespace App\Service;

use App\Storage\StorageFactory;


class MediaService
{

    /**
     * @var StorageFactory
     */
    private $storageFactory;


    public function __construct(StorageFactory $storageFactory)
    {
        $this->storageFactory = $storageFactory;
    }

    public function create(string $name): string
    {
        $producedImage = $this->storageFactory->produce($name);
        if (!$producedImage) {
            throw new \RuntimeException();
        }

        $mediaUrl = $this->storageFactory->save($producedImage);
        if (!isset($producedImage)) {
            throw new \RuntimeException();
        }

        return $mediaUrl;
    }

    public function delete(string $mediaUrl)
    {
        if (!$this->storageFactory->delete($mediaUrl)) {
            throw new \RuntimeException();
        }
    }
}
