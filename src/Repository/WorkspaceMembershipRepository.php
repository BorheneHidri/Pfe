<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Workspace;
use App\Entity\WorkspaceMembership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceMembership>
 */
class WorkspaceMembershipRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, WorkspaceMembership::class);
        $this->entityManager = $entityManager;
    }
    public function create(Workspace $workspace , Member $member):WorkspaceMembership{
        $workspaceMembership = new WorkspaceMembership();
        $workspaceMembership->setWorkspace($workspace);
        $workspaceMembership->setMember($member);
        $this->entityManager->persist($workspaceMembership);
        return $workspaceMembership;

    }
    public function findMemberWorkspaces(Member |int $member ){
        return $this->createQueryBuilder('ws')
            ->join('ws.workspace', 'w')
            ->select('w.id ,w.name , w.description')
            ->where('w.member = :member')
            ->setParameter('member', $member)
            ->getQuery()
            ->getResult();
            }
}
