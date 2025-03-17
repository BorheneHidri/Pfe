<?php

namespace App\Controller;

use App\DTO\Member\MemberDTO;
use App\Repository\MemberRepository;
use App\Services\ResponsesGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MemberController extends AbstractController
{
    #[Route('/api/members', name: 'get_members', methods: ['GET'])]
    public function getMembers(MemberRepository $memberRepository): JsonResponse
    {
        $members = $memberRepository->findAll();
        $data = [];

        foreach ($members as $member) {
            $data[] = [
                'id' => $member->getId(),
                'name' => $member->getName(),
                'avatar' => $member->getAvatar(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/members', name: 'create_member', methods: ['POST'])]
    public function createMember(
        ResponsesGenerator $responsesGenerator,
        EntityManagerInterface $em,
        MemberRepository $memberRepository,
        SerializerInterface $serializer,
        Request $request
    ): Response {
        // Désérialiser la requête en DTO
        $memberDTO = $serializer->deserialize($request->getContent(), MemberDTO::class, 'json');
    
        // Création de l'entité Member à partir du DTO
        $member = $memberRepository->create($memberDTO->name, $memberDTO->avatar);
    
        $em->flush();
    
        return $responsesGenerator->generateResponse($member);
    }
}
