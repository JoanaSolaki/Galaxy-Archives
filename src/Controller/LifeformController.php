<?php

namespace App\Controller;

use App\Entity\Lifeform;
use App\Form\LifeformType;
use App\Repository\LifeformRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('lifeform')]
class LifeformController extends AbstractController
{
    #[Route('/{id}', name: 'lifeform.show')]
    public function index(int $id, LifeformRepository $lifeformRepository): Response
    {
        $lifeform = $lifeformRepository->find($id);
        return $this->render('lifeform/lifeform.html.twig', [
            "id" => $id,
            'lifeform' => $lifeform,
        ]);
    }

    #[Route('/create', name: 'lifeform.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
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

    #[Route('/{id}/edit', name: 'lifeform.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lifeform $lifeform, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LifeformType::class, $lifeform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lifeform_index');
        }

        return $this->render('lifeform/edit.html.twig', [
            'lifeform' => $lifeform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'lifeform.delete', methods: ['POST'])]
    public function delete(Request $request, Lifeform $lifeform, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lifeform->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($lifeform);
            $entityManager->flush();
            $this->addFlash('warning', 'The lifeform have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
