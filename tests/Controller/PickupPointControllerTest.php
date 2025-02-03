<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PickupPointControllerTest extends WebTestCase
{
    public function testValidPickupPointSearchFormSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pickup-points');

        $form = $crawler->selectButton('Search')->form([
            'pickup_point_search[city]' => 'Kozy',
            'pickup_point_search[street]' => 'Gajowa 27',
            'pickup_point_search[postalCode]' => '43-340',
        ]);

        $client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('h2:contains("Results")');
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

        $this->assertResponseIsSuccessful();
        $postalCodeErrorDiv = $crawler->filter('div:contains("Postal code")');
        $this->assertSame(1, $postalCodeErrorDiv->count(), 'There should be an error related to the postal code');
    }
}
