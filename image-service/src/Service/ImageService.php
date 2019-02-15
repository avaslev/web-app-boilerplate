<?php


namespace App\Service;

use App\Storage\DeletableInterface;
use App\Storage\ProducibleInterface;
use App\Storage\SavableInterface;
use App\Storage\StorageInterface;


class ImageService
{

    /** @var StorageInterface[] */
    private $storageList = [];

    public function setStorageList(array $storageList)
    {
        foreach ($storageList as $storage) {
            if ($storage instanceof StorageInterface) {
                $this->storageList[] = $storage;
            }
        }
    }

    public function addStorage (StorageInterface $storage)
    {
        $this->storageList[] = $storage;
    }

    public function create(string $name): string
    {
        foreach ($this->storageList as $storage) {
            if (($storage instanceof ProducibleInterface) && !isset($producedImage)) {
                try {
                    $producedImage = $storage->produce($name);
                } catch (\Exception $exception) {
                    // log
                    continue;
                }
            }
        }

        if (!isset($producedImage)) {
            // log
            throw new \RuntimeException();
        }

        foreach ($this->storageList as $storage) {
            if (($storage instanceof SavableInterface)) {
                try {
                    return $storage->save($producedImage);
                } catch (\Exception $exception) {
                    // log
                    continue;
                }
            }
        }

        throw new \RuntimeException();
    }

    public function delete(string $mediaUrl)
    {
        foreach ($this->storageList as $storage) {
            if (($storage instanceof DeletableInterface)) {
                try {
                    $storage->delete($mediaUrl);
                    return;
                } catch (\Exception $exception) {
                    // log
                    continue;
                }
            }
        }
        throw new \RuntimeException();
    }
}
