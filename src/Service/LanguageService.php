<?php
namespace App\Service;

use App\Entity\Language;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LanguageService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TimeLineRepository
     */
    private $repository;



    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Language::class);
    }

      /**
     * @param $request
     * @return Language|null|object
     */
    public function getUsedLanguage(Request $request)
    {
        $alias = $request->getSession()->get('_locale');
       
        return $this->repository->findOneByAlias($alias);
    }

}