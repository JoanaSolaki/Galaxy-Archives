<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Form\PlanetType;
use App\Repository\PlanetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('planet')]
class PlanetController extends AbstractController
{
    #[Route('/add', name: 'planet.add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $planet = new Planet();
        $form = $this->createForm(PlanetType::class, $planet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planet->setCreatedAt(new DateTime());
            $planet->setAuthor($security->getUser());
            $entityManager->persist($planet);
            $entityManager->flush();

            $planetId = $planet->getId();

            $this->addFlash('success', 'Your planet have been created.');

            return $this->redirectToRoute('planet.show', ['id' => $planetId]);
        }

        return $this->render('planet/add.html.twig', [
            'planet' => $planet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'planet.show')]
    public function show(int $id, PlanetRepository $planetRepository): Response
    {
        $planet = $planetRepository->find($id);
        return $this->render('planet/planet.html.twig', [
            'id' => $id,
            'planet' => $planet,
        ]);
    }

    #[Route('/{id}/edit', name: 'planet.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planet $planet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanetType::class, $planet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planet_index');
        }

        return $this->render('planet/edit.html.twig', [
            'planet' => $planet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'planet.delete', methods: ['POST'])]
    public function delete(Request $request, Planet $planet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planet->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($planet);
            $entityManager->flush();
            $this->addFlash('warning', 'The planet have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
