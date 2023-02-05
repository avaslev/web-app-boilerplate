<?php namespace App\Tests\Storage;


use App\Storage\InstagramStorage;
use App\Storage\LoremSpaceStorage;
use Codeception\Test\Unit;

class LoremSpaceStorageTest extends Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    public function testProduce()
    {
        $storage = new LoremSpaceStorage();
        $storage->produce('test');
    }
}
