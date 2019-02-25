<?php


namespace App\Storage;


class CompositeStorage implements ProducibleInterface, SavableInterface, DeletableInterface
{


    /**
     * @var array|StorageInterface[]
     */
    private $storageList = [];

    public function addStorage (StorageInterface $storage)
    {
        $this->storageList[] = $storage;
    }

    public function setStorageList (array $storageList)
    {
        $this->storageList = $storageList;
    }

    public function delete(string $mediaName): bool
    {
        foreach ($this->storageList as $storage) {
            if (($storage instanceof DeletableInterface)) {
                try {
                    return $storage->delete($mediaName);
                } catch (\Exception $exception) {
                    // log
                    continue;
                }
            }
        }
        return false;
    }

    public function produce(string $name): string
    {

        foreach ($this->storageList as $storage) {
            if (($storage instanceof ProducibleInterface)) {
                try {
                    return $storage->produce($name);
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }
        return '';
    }

    public function save(string $file): string
    {
        foreach ($this->storageList as $storage) {
            if (($storage instanceof SavableInterface)) {
                try {
                    return $storage->save($file);
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }
        return '';
    }


}
