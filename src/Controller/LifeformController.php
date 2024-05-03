<?php

namespace App\Controller;

use App\Entity\Lifeform;
use App\Form\LifeformType;
use App\Repository\LifeformRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class LifeformController extends AbstractController
{
    #[Route('lifeform/create', name: 'lifeform.create', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $lifeform = new Lifeform();
        $form = $this->createForm(LifeformType::class, $lifeform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lifeform->setCreatedAt(new DateTime());
            $lifeform->setAuthor($security->getUser());
            $entityManager->persist($lifeform);
            $entityManager->flush();

            $lifeformId = $lifeform->getId();

            $this->addFlash('success', 'Your lifeform have been created.');

            return $this->redirectToRoute('lifeform.show', ['id' => $lifeformId]);
        }

        return $this->render('lifeform/add.html.twig', [
            'lifeform' => $lifeform,
            'form' => $form,
        ]);
    }

    #[Route('lifeform/', name: 'lifeform')]
    public function index(LifeformRepository $lifeformRepository): Response
    {
        $lifeforms = $lifeformRepository->findAll();
        return $this->render('lifeform/lifeform.html.twig', [
            'lifeforms' => $lifeforms,
        ]);
    }

    #[Route('lifeform/{id}', name: 'lifeform.show')]
    public function show(int $id, LifeformRepository $lifeformRepository): Response
    {
        $lifeform = $lifeformRepository->find($id);
        return $this->render('lifeform/show.html.twig', [
            "id" => $id,
            'lifeform' => $lifeform,
        ]);
    }

    #[Route('lifeform/filter/{species}', name: 'lifeform.filter', methods: ['GET'])]
    public function filterByType(Request $request, LifeformRepository $lifeformRepository): JsonResponse
    {
        $species = $request->get('species');
        $lifeforms = $lifeformRepository->findBy(['species' => $species]);

        $lifeformData = array_map(function ($lifeform) {
            return [
                'id' => $lifeform->getId(),
                'name' => $lifeform->getName(),
                'image' => $lifeform->getImageName(),
            ];
        }, $lifeforms);

        return $this->json($lifeformData);
    }


    #[Route('lifeform/{id}/edit', name: 'lifeform.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lifeform $lifeform, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LifeformType::class, $lifeform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lifeform->setUpdatedAt(new DateTime());

            $entityManager->flush();
            
            $lifeformId = $lifeform->getId();

            $this->addFlash('success', 'Your lifeform have been updated.');

            return $this->redirectToRoute('lifeform.show', ['id' => $lifeformId]);
        }

        return $this->render('lifeform/edit.html.twig', [
            'lifeform' => $lifeform,
            'form' => $form,
        ]);
    }

    #[Route('lifeform/{id}/delete', name: 'lifeform.delete', methods: ['POST'])]
    public function delete(Request $request, Lifeform $lifeform, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lifeform->getId(), $request->getPayload()->get('_token'))) {
            $reports = $lifeform->getReportLifeforms();

            foreach ($reports as $report) {
                $entityManager->remove($report);
            }

            $entityManager->remove($lifeform);
            $entityManager->flush();
            $this->addFlash('warning', 'The lifeform have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
