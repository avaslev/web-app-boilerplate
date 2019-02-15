<?php


namespace App\Storage;


interface SavableInterface
{
    public function save(string $file): string ;
}
