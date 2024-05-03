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
    public function getContentByArticlesQueryBuilder( $langId , $articleIds,array $params)
    {
//        $stringArticleIds = implode(",", $articleIds);
        $publishedDate = isset($params['published_date'])? $params['published_date']:null;
        $keySearch = isset($params['key_search'])?$params['key_search']:null;
        
        
        $qb = $this->createQueryBuilder('t'); 
        $qb = $qb
            ->where('t.article IN (:articleIds)')
            ->andwhere('t.language = :langId')
            ->andwhere('t.published = :published')
            ->setParameter('articleIds', $articleIds)
            ->setParameter('langId', $langId)
            ->setParameter('published', true);
            
            if(isset($publishedDate) && $publishedDate > 2000){
                $startDate = new \DateTime($publishedDate .'-01-01');
                $endDate = new \DateTime($publishedDate .'-12-31');
                $qb->andWhere($qb->expr()->between('t.published_date', ':startDate', ':endDate'));
                $qb->setParameter('startDate', $startDate);
                $qb->setParameter('endDate', $endDate);
            }
    
            if(isset($keySearch)){
                $qb->andwhere($qb->expr()->like('t.body', ':keySearch'))
                ->setParameter('keySearch', '%' . $keySearch . '%');
            }
            
            
            
            $qb->orderBy('t.published_date', 'DESC')
            ->getQuery();
        
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
