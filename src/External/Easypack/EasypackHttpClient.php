<?php

declare(strict_types=1);

namespace App\External\Easypack;

use App\External\Easypack\Response\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EasypackHttpClient implements EasypackClientInterface
{
    private const POINTS_RESOURCE = 'points';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly SerializerInterface $serializer,
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
        return $this->get(self::POINTS_RESOURCE, [
            'city' => $city,
        ]);
    }
}
