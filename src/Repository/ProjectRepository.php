<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projects>
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function create(string $name, string |null $description, array $memberIds = [] ): Project
    {
        $project = new Project();
        $project->setName($name);
        $project->setDescription($description);

        // Fetch and add members
        if (!empty($memberIds)) {
            $memberRepository = $this->getEntityManager()->getRepository(Member::class);
            foreach ($memberIds as $memberId) {
                $member = $memberRepository->find($memberId);
                if ($member) {
                    $project->addMember($member);
                }
            }
        }
        $this->getEntityManager()->persist($project);
        return $project;
    }

//    /**
//     * @return Projects[] Returns an array of Projects objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Projects
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
