<?php

declare(strict_types=1);

namespace App\External\Easypack;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class EasypackHttpClient implements EasypackClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly BaseUrl $baseUrl,
    ) {
    }

    public function get(string $resource, array $queryData): ResponseInterface
    {
        $url = sprintf('%s/%s', $this->baseUrl->asString(), $resource);

        return $this->httpClient->request('GET', $url, [
            'query' => $queryData,
        ]);
    }
}
