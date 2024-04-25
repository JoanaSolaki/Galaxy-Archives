<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GalaxyController extends AbstractController
{
    #[Route('/galaxy', name: 'app_galaxy')]
    public function index(): Response
    {
        return $this->render('galaxy/index.html.twig', [
            'controller_name' => 'GalaxyController',
        ]);
    }
}
