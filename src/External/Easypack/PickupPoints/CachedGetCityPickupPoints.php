<?php

declare(strict_types=1);

namespace App\External\Easypack\PickupPoints;

use App\Service\Hasher\HasherInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CachedGetCityPickupPoints implements GetCityPickupPoints
{
    public function __construct(
        private GetCityPickupPoints $getCityPickupPoints,
        private CacheInterface $cityPickupPointsCache,
        private HasherInterface $hasher,
    ) {
    }

    public function getCityPickupPoints(string $city): CityPickupPoints
    {
        return $this->cityPickupPointsCache->get($this->hasher->hash($city), function (ItemInterface $item) use ($city) {
            $item->expiresAfter(new \DateInterval('P3D'));

            return $this->getCityPickupPoints->getCityPickupPoints($city);
        });
    }
}
