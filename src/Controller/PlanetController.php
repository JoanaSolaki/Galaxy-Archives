<?php

namespace App\Controller;

use App\Entity\Galaxy;
use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanetController extends AbstractController
{
    #[Route('/planet/{id}', name: 'planet.show')]
    public function index(int $id, PlanetRepository $planetRepository): Response
    {
        $planet = $planetRepository->find($id);
        return $this->render('planet/planet.html.twig', [
            'id' => $id,
            'planet' => $planet,
        ]);
    }
}
