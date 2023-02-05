<?php


namespace App\Storage;


use Goutte\Client;

final class LoremSpaceStorage implements StorageInterface, ProducibleInterface
{

    private const URL = 'https://api.lorem.space/image?w=300&h=300';
    private Client $goutteClient;

    public function __construct()
    {
        $this->goutteClient = new Client();
    }

    public function produce(string $name): string
    {
        $result = $this->goutteClient->request('GET', self::URL);

        return $this->uploadImage($result->getUri());
    }

    private function uploadImage (string $url): string
    {
        $imageName = '/tmp/' . base64_encode(random_bytes(10)) . '.' . pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        try {
            file_put_contents($imageName, file_get_contents($url));
        } catch (\Exception $exception) {
            if (file_exists($imageName)) {
                unlink($imageName);
            }
            throw new \RuntimeException('Failed to save file');
        }

        return $imageName;
    }

}
