<?php

namespace App\Controller\api;

use App\DTO\User;
use App\Repository\UserRepository;
use App\Services\ResponsesGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user' , name: 'users_')]
class UserController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload] User\UserDTO $userDTO,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        ResponsesGenerator $responsesGenerator
    ): Response {
        // Appel du repository pour sauvegarder l'entité
        $user = $userRepository->create($userDTO->username,$userDTO->email, $userDTO->password, $userDTO->fullname);
        $em->flush();

        // Retourne la réponse
        return $responsesGenerator->generateResponse($user);
    }
}
