<?php

namespace App\Controller;

use App\Entity\ReportLifeform;
use App\Form\ReportLifeformType;
use App\Repository\ReportLifeformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lifeform/report')]
class ReportLifeformController extends AbstractController
{
    #[Route('/{id}/add', name: 'lifeform.report.add', methods: ['GET', 'POST'])]
    public function add(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $reportLifeform = new ReportLifeform();
        $form = $this->createForm(ReportLifeformType::class, $reportLifeform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reportLifeform);
            $entityManager->flush();

            $idLifeform = $reportLifeform->getLifeform();
            $idLifeform = $idLifeform->getId();
            
            $this->addFlash('success', 'Your report have been created.');

            return $this->redirectToRoute('lifeform.show', ['id' => $idLifeform]);
        }

        return $this->render('report_lifeform/add.html.twig', [
            'report_lifeform' => $reportLifeform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'lifeform.report.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReportLifeform $reportLifeform, EntityManagerInterface $entityManager): Response
    {
        $idLifeform = $reportLifeform->getLifeform();
        $idLifeform = $idLifeform->getId();

        $form = $this->createForm(ReportLifeformType::class, $reportLifeform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your report have been updated.');

            return $this->redirectToRoute('lifeform.show', [
                'id' => $idLifeform
            ]);
        }

        return $this->render('report_lifeform/edit.html.twig', [
            'report_lifeform' => $reportLifeform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'lifeform.report.delete', methods: ['POST'])]
    public function delete(Request $request, ReportLifeform $reportLifeform, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reportLifeform->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($reportLifeform);
            $entityManager->flush();
            $this->addFlash('warning', 'The report have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
