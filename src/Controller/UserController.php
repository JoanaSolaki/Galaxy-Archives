<?php

namespace App\Controller;

use App\Entity\Lifeform;
use App\Entity\Planet;
use App\Entity\ReportLifeform;
use App\Entity\ReportPlanet;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'user')]
    public function index(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        return $this->render('user/user.html.twig', [
            'id' => $id,
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $userId = $user->getId();

            $this->addFlash('success', 'Your profile have been updated.');

            return $this->redirectToRoute('user', ['id' => $userId]);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'user.delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $this->container->get('security.token_storage')->setToken(null);

            $anonymousUser = $entityManager->getRepository(User::class)->findOneBy(['email' => 'anonymous@anonymous.com']);

            $planets = $entityManager->getRepository(Planet::class)->findBy(['author' => $user]);

            foreach ($planets as $planet) {
                $planet->setAuthor($anonymousUser);
                $entityManager->persist($planet);
            }

            $lifeforms = $entityManager->getRepository(Lifeform::class)->findBy(['author' => $user]);

            foreach ($lifeforms as $lifeform) {
                $lifeform->setAuthor($anonymousUser);
                $entityManager->persist($lifeform);
            }

            $reportPlanets = $entityManager->getRepository(ReportPlanet::class)->findBy(['author' => $user]);

            foreach ($reportPlanets as $reportPlanet) {
                $reportPlanet->setAuthor($anonymousUser);
                $entityManager->persist($reportPlanet);
            }

            $reportlifeforms = $entityManager->getRepository(ReportLifeform::class)->findBy(['author' => $user]);

            foreach ($reportlifeforms as $reportlifeform) {
                $reportlifeform->setAuthor($anonymousUser);
                $entityManager->persist($reportlifeform);
            }

            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('warning', 'This profile have been removed.');
        }

        return $this->redirectToRoute('homepage');
    }
}
