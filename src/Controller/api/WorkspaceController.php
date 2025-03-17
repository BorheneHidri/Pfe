<?php

namespace App\Controller\api;

use App\DTO\Workspace\WorkspaceDTO;
use App\Entity\User;
use App\Entity\Workspace;
use App\Entity\WorkspaceMembership;
use App\Repository\WorkspaceMembershipRepository;
use App\Repository\WorkspaceRepository;
use App\Services\ResponsesGenerator;

use ContainerGSCL0VF\getWorkspaceMembershipRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/workspaces', name: 'workspaces_')]
final class WorkspaceController extends AbstractController
{   
    #[Route('', name: 'create', methods: ['POST'])]
    public function createWorkspace(
        #[MapRequestPayload] WorkspaceDTO $workspaceDTO,
        WorkspaceRepository $workspaceRepository,
        EntityManagerInterface $em,
        ResponsesGenerator $responsesGenerator
    ): Response {

        /** @var User $user */
        $user = $this->getUser();
        dd($user);
        // Appel du repository pour sauvegarder l'entité
           $workspace =  $workspaceRepository ->create($workspaceDTO->name,$user->getMember(),$workspaceDTO->description);
            $em->flush();

        // Retourne le workspace créé
            return $responsesGenerator->generateResponse($workspace);
    }

 #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
 public function deleteWorkspace(
    int $id,
    WorkspaceRepository $workspaceRepository,
    EntityManagerInterface $em,
    ResponsesGenerator $responsesGenerator
): JsonResponse {
    $workspace = $workspaceRepository->find($id);

    if (!$workspace) {
        return $responsesGenerator->createResponse(['message' => 'Workspace not found'], Response::HTTP_NOT_FOUND);
    }

    $em->remove($workspace);
    $em->flush();

    // You might choose to return a confirmation DTO or simple message
    return $responsesGenerator->createResponse(
        ['message' => 'Workspace deleted successfully'],
        Response::HTTP_OK
    );
}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ResponsesGenerator            $responsesGenerator,
                         WorkspaceMembershipRepository $workspaceMembershipRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $workspaces = $workspaceMembershipRepository->findMemberWorkspaces($user->getMember());
        $responsesGenerator->generateResponse($workspaces);
        return $responsesGenerator->generateResponse($workspaces);
    }
}