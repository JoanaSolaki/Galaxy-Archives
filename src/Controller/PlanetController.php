<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Form\PlanetType;
use App\Repository\PlanetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class PlanetController extends AbstractController
{
    #[Route('planet/add', name: 'planet.add', methods: ['GET', 'POST'])]
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

    #[Route('/planet', name: 'planet')]
    public function index(PlanetRepository $planetRepository): Response
    {
        $planets = $planetRepository->findAll();
        return $this->render('planet/planet.html.twig', [
            'planets' => $planets,
        ]);
    }

    #[Route('planet/{id}', name: 'planet.show')]
    public function show(int $id, PlanetRepository $planetRepository): Response
    {
        $planet = $planetRepository->find($id);
        return $this->render('planet/show.html.twig', [
            'id' => $id,
            'planet' => $planet,
        ]);
    }

    #[Route('planet/filter/{type}', name: 'planet.filter', methods: ['GET'])]
    public function filterByType(Request $request, PlanetRepository $planetRepository): JsonResponse
    {
        $type = $request->get('type');
        $planets = $planetRepository->findBy(['type' => $type]);

        $planetData = array_map(function ($planet) {
            return [
                'id' => $planet->getId(),
                'name' => $planet->getName(),
                'image' => $planet->getImageName(),
            ];
        }, $planets);

        return $this->json($planetData);
    }

    #[Route('planet/{id}/edit', name: 'planet.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planet $planet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanetType::class, $planet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planet->setUpdatedAt(new DateTime());

            $entityManager->flush();

            $planetId = $planet->getId();

            $this->addFlash('success', 'Your planet have been updated.');

            return $this->redirectToRoute('planet.show', ['id' => $planetId]);
        }
        return $this->render('planet/edit.html.twig', [
            'planet' => $planet,
            'form' => $form,
        ]);
    }

    #[Route('planet/{id}/delete', name: 'planet.delete', methods: ['POST'])]
    public function delete(Request $request, Planet $planet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planet->getId(), $request->getPayload()->get('_token'))) {
            $reports = $planet->getReportPlanets();

            foreach ($reports as $report) {
                $entityManager->remove($report);
            }

            $entityManager->remove($planet);
            $entityManager->flush();
            $this->addFlash('warning', 'The planet have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
