<?php


namespace App\Storage;


interface DeletableInterface
{
    public function delete(string $mediaName): bool;
}
