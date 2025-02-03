<?php

declare(strict_types=1);

namespace App\External\Easypack;

use App\External\Easypack\Response\Response;

interface EasypackClientInterface
{
    public function getCityPickupPoints(string $city): Response;
}
