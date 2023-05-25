<?php
namespace App\Service;

use App\Entity\Content;
use App\Entity\TimeLine;
use App\Repository\ContentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use App\Utils\Paginator;
use Knp\Component\Pager\PaginatorInterface;

class ContentService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ContentRepository
     */
    private $repository;

    /**
     * TimeLineManager constructor.
     * @param PaginatorInterface $em
     */
    private $paginator;

    public function __construct(EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Content::class);
        $this->paginator = $paginator;
    }

    /**
     * @param $id
     * @return Content|null|object
     */
    public function getArticle($id)
    {
        return $this->repository->find($id);
    }

    public function getTimeLines( $page, $limit,  $langId )
    {
        $pagination = $this->paginator->paginate($this->repository->getTimeLinesQueryBuilder( $langId ), $page, $limit);
        return $pagination;

    }

    public function getContentByArticles( int $page, int $limit,int $langId ,array $articleIds)
    {
        $pagination = $this->paginator->paginate($this->repository->getContentByArticlesQueryBuilder( $langId , $articleIds), $page, $limit);
        return $pagination;

    }
}
