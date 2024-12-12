<?php
namespace App\Service;

use App\Entity\TimeLine;
use Doctrine\ORM\EntityManagerInterface;

use App\Utils\Paginator;
use Knp\Component\Pager\PaginatorInterface;

class TimeLineService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TimeLineRepository
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
        $this->repository = $em->getRepository(TimeLine::class);
        $this->paginator = $paginator;
    }

    /**
     * @param $id
     * @return TimeLine|null|object
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

    public function getTimeLineByCategory( $page, $limit,  $langId )
    {
        $pagination = $this->paginator->paginate($this->repository->getTimeLinesByCategoryQueryBuilder( $langId, 'NEW'), $page, $limit);
        return $pagination;

    }

    public function getHistory(  $langId )
    {
        $list = $this->repository->getHistoryTransportQueryBuilder( $langId );
        return $list;

    }

    public function getNews(  $langId )
    {
        $list = $this->repository->getNewsQueryBuilder( $langId );
        return $list;

    }
}
