<?php

declare(strict_types=1);

namespace App\Controller;

use App\External\Easypack\EasypackClientInterface;
use App\Form\DTO\Address;
use App\Form\PickupPointSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PickupPointController extends AbstractController
{
    #[Route('/pickup-points', name: 'pickup_points')]
    public function search(Request $request, EasypackClientInterface $client): Response
    {
        $address = new Address();

        $form = $this->createForm(PickupPointSearchType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Address $data */
            $address = $form->getData();
            $response = $client->getCityPickupPoints($address->city);

            return $this->render('pickup_points/search.html.twig', [
                'form' => $form->createView(),
                'results' => $response->items,
            ]);
        }

        return $this->render('pickup_points/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
