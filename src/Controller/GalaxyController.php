<?php

namespace App\Controller;

use App\Repository\GalaxyRepository;
use App\Repository\PlanetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GalaxyController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function indexHome(GalaxyRepository $galaxyRepository, PlanetRepository $planetRepository): Response
    {
        $galaxies = $galaxyRepository->findAll();
        $planets = $planetRepository->findAll();
        return $this->render('homepage.html.twig', [
            'galaxies' => $galaxies,
            'planets' => $planets,
        ]);
    }

    #[Route('/galaxy/{id}', name: 'galaxy.show')]
    public function index(int $id, GalaxyRepository $galaxyRepository): Response
    {
        $galaxy = $galaxyRepository->find($id);
        return $this->render('galaxy/galaxy.html.twig', [
            'id' => $id,
            'galaxy' => $galaxy,
        ]);
    }
}
