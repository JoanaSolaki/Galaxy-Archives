<?php

namespace App\Controller;

use App\Entity\ReportPlanet;
use App\Form\ReportPlanetType;
use App\Repository\PlanetRepository;
use App\Repository\ReportPlanetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/planet/report')]
class ReportPlanetController extends AbstractController
{
    #[Route('/{id}/add', name: 'planet.report.add', methods: ['GET', 'POST'])]
    public function add(int $id, Request $request, EntityManagerInterface $entityManager, Security $security, PlanetRepository $planetRepository): Response
    {
        $reportPlanet = new ReportPlanet();
        $form = $this->createForm(ReportPlanetType::class, $reportPlanet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reportPlanet->setCreatedAt(new DateTime());
            $reportPlanet->setAuthor($security->getUser());
            $planetReport = $planetRepository->find($id);
            $reportPlanet->setPlanet($planetReport);
            $entityManager->persist($reportPlanet);
            $entityManager->flush();

            $idPlanet = $reportPlanet->getPlanet();
            $idPlanet = $idPlanet->getId();
            
            $this->addFlash('success', 'Your report have been created.');

            return $this->redirectToRoute('planet.show', ['id' => $idPlanet]);
        }

        return $this->render('report_planet/add.html.twig', [
            'id' => $id,
            'report_planet' => $reportPlanet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'planet.report.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReportPlanet $reportPlanet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReportPlanetType::class, $reportPlanet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reportPlanet->setUpdatedAt(new DateTime());

            $entityManager->flush();

            $idPlanet = $reportPlanet->getPlanet();
            $idPlanet = $idPlanet->getId();
            
            $this->addFlash('success', 'Your report have been updated.');

            return $this->redirectToRoute('planet.show', ['id' => $idPlanet]);
        }

        return $this->render('report_planet/edit.html.twig', [
            'report_planet' => $reportPlanet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'planet.report.delete', methods: ['POST'])]
    public function delete(Request $request, ReportPlanet $reportPlanet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reportPlanet->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($reportPlanet);
            $entityManager->flush();
            $this->addFlash('warning', 'The report have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
