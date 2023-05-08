<?php

namespace App\Utils;

use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\PackageInterface;

class Paginator 
{
    private $knpPaginator;

    public function __construct(PaginatorInterface $knpPaginator)
    {
        $this->knpPaginator = $knpPaginator;
    }

    /**
     * @param mixed $target
     * @param int $page
     * @param int $limit
     * @param array $options
     * @return array|\Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginate($target, $page = 1, int $limit = null, array $options = [])
    {
        /** @var SlidingPagination $pagination */
        $pagination = $this->knpPaginator->paginate($target, $page, $limit, $options);

        return [
            'items' => $pagination->getItems(),
            'totalCount' => $pagination->getTotalItemCount(),
            'page' => $pagination->getCurrentPageNumber(),
            'limit' => $pagination->getItemNumberPerPage(),
        ];
    }
}