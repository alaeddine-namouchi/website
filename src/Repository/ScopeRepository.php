<?php

namespace App\Repository;

use App\Entity\ProfileScope;
use App\Entity\Scope;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Scope>
 *
 * @method Scope|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scope|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scope[]    findAll()
 * @method Scope[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScopeRepository extends ServiceEntityRepository
{
    private $profileRepository;
    public function __construct(ManagerRegistry $registry, Security $security, ProfileScopeRepository $profileRepository)
    {
        parent::__construct($registry, Scope::class);
        $this->security = $security;
        $this->profileRepository = $profileRepository;
    }

    public function add(Scope $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Scope $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function  scopeProfileQueryBuilder(){
        $user = $this->security->getUser();

        $profileScopes = $this->profileRepository->findBy(['profile'=>$user->getProfile()]);
        $scopeIds = [];
        foreach ($profileScopes as $item){
            $scopeIds[] = $item->getScope()->getId();
        }
//        dd($scopeIds);

        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.id IN (:scopeIds)')
            ->setParameter('scopeIds', $scopeIds);
        return $qb;
    }

//    /**
//     * @return Scope[] Returns an array of Scope objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Scope
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
