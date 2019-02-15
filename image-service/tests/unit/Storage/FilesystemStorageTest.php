<?php namespace App\Tests\Storage;


use App\Storage\FilesystemStorage;
use Codeception\Test\Unit;

class FilesystemStorageTest extends Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testDelete()
    {
        $mediaName = '/test.txt';
        $mediaPrefix = '/';
        $fileDir = '/tmp';

        $fh = fopen($fileDir . $mediaName, 'a', true);
        fwrite($fh, '<h1>Delete me</h1>');
        fclose($fh);

        $storage = new FilesystemStorage($mediaPrefix, $fileDir);

        $this->tester->assertTrue(file_exists($fileDir . $mediaName ));
        $storage->delete($mediaName);
        $this->tester->assertFalse(file_exists($fileDir . $mediaName));
    }

    public function testSave()
    {
        $tmpFile = '/tmp/new_' . time() . '.jpg';
        $mediaPrefix = '/';
        $fileDir = '/tmp';

        $fh = fopen($tmpFile, 'a', true);
        fwrite($fh, '10');
        fclose($fh);

        $storage = new FilesystemStorage($mediaPrefix, $fileDir);
        $mediaName = $storage->save($tmpFile);

        $this->tester->assertFalse(file_exists($tmpFile));
        $this->tester->assertTrue(file_exists($fileDir . $mediaName));
        unlink($fileDir . $mediaName);
    }
}
