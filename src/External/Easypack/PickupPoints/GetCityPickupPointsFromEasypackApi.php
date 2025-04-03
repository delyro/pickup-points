<?php

declare(strict_types=1);

namespace App\External\Easypack\PickupPoints;

use App\External\Easypack\EasypackClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GetCityPickupPointsFromEasypackApi implements GetCityPickupPoints
{
    private const string POINTS_RESOURCE = 'points';

    public function __construct(
        private readonly EasypackClientInterface $client,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function getCityPickupPoints(string $city): CityPickupPoints
    {
        $response = $this->client->get(self::POINTS_RESOURCE, [
            'city' => $city,
        ]);

        return $this->serializer->deserialize($response->getContent(), CityPickupPoints::class, 'json');
    }
}
