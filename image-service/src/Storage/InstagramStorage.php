<?php


namespace App\Storage;


use Goutte\Client;
use Prophecy\Exception\InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class InstagramStorage implements StorageInterface, ProducibleInterface
{

    private const SHARED_DATE_URL_PATH = 'entry_data, TagPage, 0, graphql, hashtag, edge_hashtag_to_top_posts, edges, 0, node, display_url';

    public function produce(string $name): string
    {
        $shareDate = $this->getSharedDate($name);
        $imageUrl = $this->handleImageUrl($shareDate, self::SHARED_DATE_URL_PATH);
        return $this->uploadImage($imageUrl);

    }

    private function getSharedDate ($tag): array
    {
        $goutteClient = new Client();
        $url = sprintf('https://www.instagram.com/explore/tags/%s/', $tag);
        $crawler = $goutteClient->request('GET', $url);
        $sharedData = '';
        $crawler->filter('script')->each(function (Crawler $script) use (&$sharedData) {
            if (false === strpos($script->text(), 'window._sharedData') || $sharedData) {
                return;
            }
            $sharedData = $script->text();
        });

        $data = $this->handleSharedDate($sharedData);

        if (!$data) {
            throw new \RuntimeException('Failed getting shared date');
        }

        return $data;
    }

    private function handleImageUrl (array $data, string $sharedDateUrlPath): string
    {
        try {
            array_map(function ($node) use (&$data) {
                $data = $data[trim($node)];
            }, explode(',', $sharedDateUrlPath));
        } catch (\Exception $exception) {
           throw new InvalidArgumentException('Expected share date url path not found');
        }

        return (string) $data;
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

    private function handleSharedDate (string $sharedDate): array
    {
        $prefixPattern = '/([^\{]*)(.*)$/s';
        $postficPattern = '/(.*)([^\}]+)$/s';

        $json = preg_replace($prefixPattern, '$2', $sharedDate);
        $json = preg_replace($postficPattern, '$1', $json);

        try {
            $data = json_decode($json, true);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Failed handle shared date');
        }

        return $data;
    }

}
