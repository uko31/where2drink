<?php

namespace App\Repository;

use App\Entity\VoteByUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VoteByUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoteByUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoteByUser[]    findAll()
 * @method VoteByUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteByUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoteByUser::class);
    }

    // /**
    //  * @return VoteByUser[] Returns an array of VoteByUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoteByUser
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
