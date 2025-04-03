<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group slow
 */
class PickupPointControllerTest extends WebTestCase
{
    public function testValidPickupPointSearchFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pickup-points');

        $form = $crawler->selectButton('Search')->form([
            'pickup_point_search[city]' => 'Kozy',
        ]);

        $client->submit($form);

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('h2:contains("Results")');
        self::assertSelectorExists('p:contains("Number of points: 13")');
        self::assertSelectorTextContains('li:nth-child(1)', 'KZY01A: Gajowa 27 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(2)', 'KZY01APP: Zagrodowa 12 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(3)', 'KZY01BAPP: Krakowska 104 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(4)', 'KZY01M: Bielska 57 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(5)', 'KZY01N: Krakowska 42 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(6)', 'KZY02M: Przecznia 60 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(7)', 'KZY03M: Bielska 149 43-340 Koz');
        self::assertSelectorTextContains('li:nth-child(8)', 'KZY04M: Przecznia 2 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(9)', 'KZY05M: Panienki 11 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(10)', 'KZY06M: Spacerowa 9 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(11)', 'KZY07M: Klonowa 1 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(12)', 'KZY08M: Krzemowa 50 43-340 Kozy');
        self::assertSelectorTextContains('li:nth-child(13)', 'POP-KZY2: Krakowska 38A 43-340 Kozy');
    }

    public function testInvalidPickupPointSearchFormSubmissionWithoutPostalCode(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pickup-points');

        $form = $crawler->selectButton('Search')->form([
            'pickup_point_search[city]' => 'Kozy',
            'pickup_point_search[street]' => 'Gajowa 27',
        ]);

        $client->submit($form);

        self::assertResponseIsSuccessful();
        $postalCodeErrorDiv = $crawler->filter('div:contains("Postal code")');
        self::assertSame(1, $postalCodeErrorDiv->count(), 'There should be an error related to the postal code');
    }
}
