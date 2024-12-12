<?php

namespace App\Repository;

use App\Entity\ProfilAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfilAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilAction[]    findAll()
 * @method ProfilAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilAction::class);
    }

    // /**
    //  * @return ProfilAction[] Returns an array of ProfilAction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfilAction
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
