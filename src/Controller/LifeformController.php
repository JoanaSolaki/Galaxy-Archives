<?php

namespace App\Controller;

use App\Repository\LifeformRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LifeformController extends AbstractController
{
    #[Route('/lifeform/{id}', name: 'lifeform.show')]
    public function index(int $id, LifeformRepository $lifeformRepository): Response
    {
        $lifeform = $lifeformRepository->find($id);
        return $this->render('lifeform/lifeform.html.twig', [
            "id" => $id,
            'lifeform' => $lifeform,
        ]);
    }
}
