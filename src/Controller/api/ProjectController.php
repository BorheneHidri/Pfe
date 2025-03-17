<?php

namespace App\Controller\api;


use App\DTO\Project\ProjectDTO;
use App\Repository\ProjectRepository;
use App\Services\ResponsesGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects', name: 'project_')]
class ProjectController extends AbstractController
{
    #[Route('', name: 'create', methods: ['POST'])]
    public function createProject(
        #[MapRequestPayload] ProjectDTO $projectDTO,
        ProjectRepository $projectRepository,
        EntityManagerInterface $em,
        ResponsesGenerator $responsesGenerator
    ): Response {
        // Call repository to create project
        $project = $projectRepository->create($projectDTO->name, $projectDTO->description, $projectDTO->members);
        $em->flush();
        // Return the created project
        return $responsesGenerator->generateResponse($project);
    }
    #[Route('', name: 'list', methods: ['GET'])]

    public function listProjects(ProjectRepository $projectRepository):Response
    {
        $projects = $projectRepository->findAll();
        return $this->json($projects, Response::HTTP_OK);
    }


}
