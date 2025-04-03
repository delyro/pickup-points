<?php

namespace App\Tests\Integration\External\Easypack\PickupPoints;

use App\External\Easypack\EasypackClientInterface;
use App\External\Easypack\PickupPoints\CityPickupPoint\Address;
use App\External\Easypack\PickupPoints\CityPickupPoint\Item;
use App\External\Easypack\PickupPoints\GetCityPickupPointsFromEasypackApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @group slow
 */
class GetCityPickupPointsFromEasypackApiTest extends KernelTestCase
{
    private readonly GetCityPickupPointsFromEasypackApi $easypackApi;

    public function setUp(): void
    {
        self::bootKernel();

        $easypackClient = self::getContainer()->get(EasypackClientInterface::class);
        $serializer = self::getContainer()->get(SerializerInterface::class);

        $this->easypackApi = new GetCityPickupPointsFromEasypackApi($easypackClient, $serializer);
    }

    public function testCityPickupPoints(): void
    {
        $response = $this->easypackApi->getCityPickupPoints('Kozy');

        self::assertSame(13, $response->count);
        self::assertSame(1, $response->page);
        self::assertSame(1, $response->totalPages);

        self::assertInstanceOf(Item::class, $response->items[0]);
        self::assertSame('KZY01A', $response->items[0]->name);
        self::assertInstanceOf(Address::class, $response->items[0]->address);
        self::assertSame('Gajowa 27', $response->items[0]->address->line1);
        self::assertSame('43-340 Kozy', $response->items[0]->address->line2);
    }
}
