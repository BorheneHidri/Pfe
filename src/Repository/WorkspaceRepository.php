<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Workspace;
use App\Entity\WorkspaceMembership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workspace>
 */
class WorkspaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry , private WorkspaceMembershipRepository $membershipRepository)
    {
        parent::__construct($registry, Workspace::class);
                 }
    
    public function create(string $name ,Member |int $member ,string |null $description): Workspace
    {

        $workspace = new Workspace();
        $workspace -> setName($name);
        $workspace -> setDescription($description);
        $this->membershipRepository->create($workspace,$member);
        $this->getEntityManager()->persist($workspace);

        return $workspace;
    }
   
    public function delete(Workspace $workspace)
    {
        $this->getEntityManager()->remove($workspace);
    }


    //    /**
    //     * @return Workspace[] Returns an array of Workspace objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Workspace
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
