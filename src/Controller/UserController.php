<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
