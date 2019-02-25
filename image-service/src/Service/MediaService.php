<?php


namespace App\Service;

use App\Storage\CompositeStorage;


class MediaService
{

    /**
     * @var CompositeStorage
     */
    private $compositeStorage;


    public function __construct(CompositeStorage $compositeStorage)
    {
        $this->compositeStorage = $compositeStorage;
    }

    public function create(string $name): string
    {
        $producedImage = $this->compositeStorage->produce($name);
        if (!$producedImage) {
            throw new \RuntimeException();
        }

        $mediaUrl = $this->compositeStorage->save($producedImage);
        if (!isset($producedImage)) {
            throw new \RuntimeException();
        }

        return $mediaUrl;
    }

    public function delete(string $mediaUrl)
    {
        if (!$this->compositeStorage->delete($mediaUrl)) {
            throw new \RuntimeException();
        }
    }
}
