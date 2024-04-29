<?php

namespace App\Controller;

use App\Entity\Galaxy;
use App\Form\GalaxyType;
use App\Repository\GalaxyRepository;
use App\Repository\PlanetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
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

    #[Route('/galaxy/create', name: 'galaxy.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $galaxy = new Galaxy();
        $form = $this->createForm(GalaxyType::class, $galaxy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($galaxy);
            $entityManager->flush();

            return $this->redirectToRoute('app_galaxy_index');
        }

        return $this->render('galaxy/add.html.twig', [
            'galaxy' => $galaxy,
            'form' => $form,
        ]);
    }

    #[Route('/galaxy/{id}/edit', name: 'galaxy.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Galaxy $galaxy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GalaxyType::class, $galaxy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_galaxy_index');
        }

        return $this->render('galaxy/edit.html.twig', [
            'galaxy' => $galaxy,
            'form' => $form,
        ]);
    }

    #[Route('/galaxy/{id}/delete', name: 'galaxy.delete', methods: ['POST'])]
    public function delete(Request $request, Galaxy $galaxy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galaxy->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($galaxy);
            $entityManager->flush();
            $this->addFlash('warning', 'Galaxy and this components have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
