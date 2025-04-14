<?php

declare(strict_types=1);

namespace App\External\Easypack\PickupPoints;

interface GetCityPickupPoints
{
    public function getCityPickupPoints(string $city): CityPickupPoints;
}
