<?php


namespace App\Storage;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Class FilesystemStorage
 * @package App\Storage
 */
class FilesystemStorage implements StorageInterface, DeletableInterface, SavableInterface
{

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var string
     */
    private $mediaPrefix;
    /**
     * @var string
     */
    private $filesDir;

    public function __construct(string $mediaPrefix, string $filesDir)
    {

        $this->filesystem = new Filesystem();
        $this->mediaPrefix = $mediaPrefix;
        $this->filesDir = $filesDir;
    }

    /**
     * @param string $file
     * @return string
     */
    public function save(string $file): string
    {
        if (!$this->filesystem->exists($file)) {
            throw new FileNotFoundException();
        }
        $fileInfo = new \SplFileInfo($file);
        $mediaName = time() . '.' . $fileInfo->getExtension();
        $targetFile = $this->filesDir . '/' . $mediaName;
        $this->filesystem->copy($fileInfo->getPathname(), $targetFile);
        $this->filesystem->remove($fileInfo->getPathname());
        return $this->mediaPrefix . $mediaName;
    }


    /**
     * @param string $mediaName
     * @return bool
     */
    public function delete(string $mediaName): bool
    {
        $this->support($mediaName);

        $filePath = $this->handleName($mediaName);
        if ($this->filesystem->exists($filePath)) {
            $this->filesystem->remove($filePath);
        }
        return true;
    }

    /**
     * @param string $name
     */
    private function support(string $name)
    {
        if (0 !== strpos($name, $this->mediaPrefix)) {
            throw new \InvalidArgumentException('This file not support');
        }
    }

    /**
     * @param string $mame
     * @return string
     */
    private function handleName(string $mame): string
    {
        return $this->filesDir . '/' . str_replace($this->mediaPrefix, '', $mame);
    }
}
