<?php

namespace App\Repository;

use App\Entity\TimeLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeLine[]    findAll()
 * @method TimeLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeLine::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TimeLine $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TimeLine $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function getTimeLinesQueryBuilder( $langId )
    {
		$qb = $this->createQueryBuilder('t');

           $qb = $qb->where('t.language = :langId')
                    ->setParameter('langId', $langId)
                    ->orderBy('t.createdAt', 'DESC');

        return $qb;
    }
    public function getTimeLinesByCategoryQueryBuilder( $langId, $aliasCategory )
    {
		$qb = $this->createQueryBuilder('t');
        // $qb = $qb->where('t.language = :langId')
        //             ->setParameter('langId', $langId)
        //             ->orderBy('t.createdAt', 'DESC');

           $qb = $qb->join('t.category', 'c')
                    // ->select('t')
                    ->where('t.language = :langId')
                    ->andWhere('c.alias=:alias_category')
                    ->setParameter('alias_category', $aliasCategory)
                    ->setParameter('langId', $langId)
                    ->orderBy('t.createdAt', 'DESC');

        return $qb;
    }

    public function getHistoryTransportQueryBuilder( $langId )
    {
		$qb = $this->createQueryBuilder('t');

           $qb = $qb->where('t.language = :langId')
                    ->setParameter('langId', $langId)
                    ->orderBy('t.createdAt', 'DESC');

        return $qb;
    }

    // /**
    //  * @return TimeLine[] Returns an array of TimeLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeLine
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
