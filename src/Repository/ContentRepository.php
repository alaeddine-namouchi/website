<?php

namespace App\Repository;

use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Content $entity, bool $flush = true): void
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
    public function remove(Content $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findArticleByLang(){

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT c.*
        FROM content c
        WHERE c.language_id = :lang
        ORDER BY c.created_at DESC
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['lang' => 1]);

        // returns an array of arrays (i.e. a raw data set)
        $res =  $resultSet->fetchAllAssociative();
        $outouts = [];
        foreach($res as $content)
        {
            $c = new Content();
            $c->setId($content['id']);
            $c->setTitle($content['title']);
            $c->setBody($content['body']);
            $c->setCreatedAt(new \DateTime($content['created_at']));
            $c->setUpdatedAt(new \DateTime($content['updated_at']));
            $c->setPublished($content['published']);
            $outouts[] = $c;

        }
        return $outouts;

        ;
    }
    public function getContentByArticlesQueryBuilder( $langId , $articleIds)
    {
//        $stringArticleIds = implode(",", $articleIds);
        $qb = $this->createQueryBuilder('t');

        $qb = $qb
            ->where('t.article IN (:articleIds)')
            ->Andwhere('t.language = :langId')
            ->Andwhere('t.published = :published')
            ->setParameter('articleIds', $articleIds)
            ->setParameter('langId', $langId)
            ->setParameter('published', true)
            ->orderBy('t.published_date', 'DESC');

        return $qb;
    }

    // /**
    //  * @return Content[] Returns an array of Content objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Content
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
