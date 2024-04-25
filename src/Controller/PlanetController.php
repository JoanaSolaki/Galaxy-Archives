<?php

namespace App\Controller;

use App\Entity\Galaxy;
use App\Entity\Planet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanetController extends AbstractController
{
    #[Route('/planet', name: 'app_planet')]
    public function index(): Response
    {
        return $this->render('planet/index.html.twig', [
            'controller_name' => 'PlanetController',
        ]);
    }
}
