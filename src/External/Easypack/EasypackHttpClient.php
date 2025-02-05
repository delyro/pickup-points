<?php

declare(strict_types=1);

namespace App\External\Easypack;

use App\External\Easypack\Response\Response;
use App\Service\Hasher\HasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EasypackHttpClient implements EasypackClientInterface
{
    private const POINTS_RESOURCE = 'points';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CacheInterface $cache,
        private readonly SerializerInterface $serializer,
        private readonly HasherInterface $hasher,
        private readonly string $baseUrl,
    ) {
    }

    public function get(string $resource, array $queryData): Response
    {
        $url = sprintf('%s/%s', $this->baseUrl, $resource);

        $response = $this->httpClient->request('GET', $url, [
            'query' => $queryData,
        ]);

        return $this->serializer->deserialize($response->getContent(), Response::class, 'json');
    }

    public function getCityPickupPoints(string $city): Response
    {
        return $this->cache->get($this->hasher->hash($city), function (ItemInterface $item) use ($city) {
            $item->expiresAfter(new \DateInterval('P3D'));

            return $this->get(self::POINTS_RESOURCE, [
                'city' => $city,
            ]);
        });
    }
}
