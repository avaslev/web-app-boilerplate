<?php


namespace App\Storage;


interface ProducibleInterface
{
    public function produce (string $name): string;
}
