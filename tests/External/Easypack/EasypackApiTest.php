<?php

declare(strict_types=1);

namespace App\Tests\External\Easypack;

use App\External\Easypack\EasypackClientInterface;
use App\External\Easypack\Response\Address;
use App\External\Easypack\Response\Item;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EasypackApiTest extends KernelTestCase
{
    private readonly EasypackClientInterface $client;

    public function setUp(): void
    {
        self::bootKernel();

        /* @var EasypackClientInterface $client */
        $this->client = self::getContainer()->get(EasypackClientInterface::class);
    }

    public function testCityPickupPoints(): void
    {
        $response = $this->client->getCityPickupPoints('Kozy');

        $this->assertSame(13, $response->count);
        $this->assertSame(1, $response->page);
        $this->assertSame(1, $response->totalPages);

        $this->assertInstanceOf(Item::class, $response->items[0]);
        $this->assertSame('KZY01A', $response->items[0]->name);
        $this->assertInstanceOf(Address::class, $response->items[0]->address);
        $this->assertSame('Gajowa 27', $response->items[0]->address->line1);
        $this->assertSame('43-340 Kozy', $response->items[0]->address->line2);
    }
}
