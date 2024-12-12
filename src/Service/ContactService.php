<?php
namespace App\Service;

use App\Entity\Contact;
use App\Entity\TimeLine;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class ContactService
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var  ContactRepository
     */
    private $repository;

    /**
     * TimeLineManager constructor.
     * @param PaginatorInterface $paginator
     */
    private $paginator;

    public function __construct(EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Contact::class);
        $this->paginator = $paginator;
    }

    /**
     * @param $id
     * @return Contact|null|object
     */
    public function getContact($id)
    {
        return $this->repository->find($id);
    }

    public function getContacts( $page, $limit )
    {
        return $this->paginator->paginate($this->repository->getContactsQueryBuilder(), $page, $limit);

    }

//    public function getTimeLineByCategory( $page, $limit,  $langId )
//    {
//        $pagination = $this->paginator->paginate($this->repository->getTimeLinesByCategoryQueryBuilder( $langId, 'NEW'), $page, $limit);
//        return $pagination;
//
//    }


}
