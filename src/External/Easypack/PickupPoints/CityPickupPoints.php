<?php

declare(strict_types=1);

namespace App\External\Easypack\PickupPoints;

use App\External\Easypack\PickupPoints\CityPickupPoint\Item;
use Symfony\Component\Serializer\Attribute\SerializedName;

class CityPickupPoints
{
    public int $count;

    public int $page;

    #[SerializedName('total_pages')]
    public int $totalPages;

    /** @var array<Item> */
    public array $items = [];
}
