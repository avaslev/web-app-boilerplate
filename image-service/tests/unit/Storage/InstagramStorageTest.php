<?php namespace App\Tests\Storage;


use App\Storage\InstagramStorage;
use Codeception\Test\Unit;

class InstagramStorageTest extends Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    /**
     * @dataProvider _sharedDateProvider
     * @param string $data
     * @param array $expect
     */
    public function testHandleSharedDate(string $data, array $expect)
    {
        $function = self::getMethod('handleSharedDate');
        $storage = new InstagramStorage();
        $this->assertEquals($expect, $function->invokeArgs($storage, [$data]));
    }

    public function testHandleImageUrl()
    {
        $function = self::getMethod('handleImageUrl');
        $storage = new InstagramStorage();

        $expect = '/image.png';
        $data = json_decode(sprintf('{"a":{"b":[{"c":"%s"}]}}', $expect), true);
        $dataPath = 'a, b, 0, c';
        $this->assertEquals($expect, $function->invokeArgs($storage, [$data, $dataPath]));
    }

    public function testUploadImage()
    {
        $function = self::getMethod('uploadImage');
        $storage = new InstagramStorage();

        $url = '/tmp/test.txt';
        $fh = fopen($url, 'a', true);
        fwrite($fh, '<h1>Delete me</h1>');
        fclose($fh);

        $uploadedFile = $function->invokeArgs($storage, [$url]);
        $this->tester->assertTrue(file_exists($uploadedFile));
        unlink($uploadedFile);
        unlink($url);
    }

    public function _sharedDateProvider()
    {
        return [
            ['any_variable = {"a":1};', ["a" => 1]],
            ['{"a":1}', ["a" => 1]],
        ];
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(InstagramStorage::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

}
