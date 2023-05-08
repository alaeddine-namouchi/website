<?php

namespace App\Controller\Back;

use App\Dto\NotificationEventDto;
use App\Entity\CustomerEvent;
use App\Manager\TrainerCacesValidityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\WebLink\Link;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\SmsNotification;
use DoctrineExtensions\Query\Mysql\Date;
use App\Dto\Transformer\AbstractDtoTransformer;
use App\Dto\Transformer\EventCustomerDtoTransformer;
use App\Dto\Transformer\DocumentDtoTransformer;
use App\Entity\Action;
use App\Entity\ActionType;
use App\Entity\Section;
use App\Entity\Training;
use App\Entity\TrainingDetail;
use App\Manager\TrainingManager;
use App\Repository\TrainingDetailRepository;
use App\Repository\TrainingModuleDocumentRepository;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\Jwt\StaticTokenProvider;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Validator\Constraints\Date as ConstraintsDate;

/**
 * Class NotificationsController
 * @package App\Controller
 *
 * 
 */

class GenerateBaseAccessController extends AbstractController
{
    private $em;


    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    public function getDataUserManagement(){

        $allRoute = $this->container->get('router')->getRouteCollection()->all();
         $tableActionByController = array();
        foreach ($allRoute as $k => $t ){

            $test = !str_starts_with($k, '_') && !str_starts_with($k, 'fos_') && !str_starts_with($k, 'fullcalendar_');         
            if( $test){
            
                $ch = $t->getDefault('_controller');
                
                $pieces = explode("::", $ch);
               
                $pathcontroller = $pieces[0];
                $action = $pieces[1];
                $cont = explode("\\", $pathcontroller);
               $controller = $cont[count($cont) - 1];

               $tableActionByController[$controller][] = ['route'=> $k, 'action'=> $action, 'path_controller' => $pathcontroller];

            }
        }
        return $tableActionByController;
    }
    /**
     * @Route("/create-data-user-management", name="_new_user_management", methods={"GET"})
     */
    public function userManagementAction( ):Response
    {
        
    
       
        $dataUserMngs = $this->getDataUserManagement();
        $list =   '';
        foreach($dataUserMngs as $key => $actions){
            $section = new Section();
            $list .=   '$section'.$key ."=  new Section();<br/>". PHP_EOL;
            $tmpName = str_replace('Controller', '', $key);
            $labelSection = strtolower($tmpName);
            $aliasSection = strtoupper($tmpName);
            $section->setLabel($labelSection);
            $section->setAlias($aliasSection);
            $section->setBusinessName($tmpName);
            $section->setDescription($key);
            $list .=   '$section'.$key.'->setLabel(\'' . $labelSection . '\');<br/>'.PHP_EOL;
            $list .=   '$section'.$key.'->setAlias(\'' . $aliasSection . '\');<br/>'.PHP_EOL;
            $list .=   '$section'.$key.'->setBusinessName(\'' . $labelSection . '\');<br/>'.PHP_EOL;
            $list .=   '$section'.$key.'->setDescription(\'' . $labelSection . '\');<br/>'.PHP_EOL;
            $list .=   '$this->em->persist(' . '$section'.$key .');<br/>'.PHP_EOL;
            $list .=   "     ".PHP_EOL;
            $actions = $dataUserMngs[$key];
            $repoActionType = $this->getDoctrine()->getRepository(ActionType::class);
            $list .=   '$repoActionType = $this->getDoctrine()->getRepository(ActionType::class);<br/>'.PHP_EOL;
            $defaultActionType = $repoActionType->findOneBy(['alias'=> 'PRINCIPAL']);
            $list .=   '$defaultActionType = $repoActionType->findOneBy([\'alias\'=> \'PRINCIPAL\']);<br/>'.PHP_EOL;
            $list .=   "     ".PHP_EOL;
             $this->em->persist($section);
             dump($defaultActionType);
            foreach ($actions as $k => $_action)
            {
                $action = new Action();
                $list .=   '$action'.$k .' = new Action();<br/>'.PHP_EOL;
$list .=   '$action'.$k .'->setLabel(\''.$_action['action'].'\')'.PHP_EOL.'->setRoute(\''.$_action['route'].'\')'.PHP_EOL.'->setAlias(strtoupper(\''.$_action['action'].'\'))'.PHP_EOL.'->setBusinessName(\'' . $_action['action'] . '\')'.PHP_EOL.'->setSection( $section'.$key .')'.PHP_EOL.'->setActionType( $defaultActionType  )'.PHP_EOL.'->setAction(Null);<br/>'.PHP_EOL;
                $action->setLabel($_action['action'])
                        ->setRoute($_action['route'])
                        ->setAlias(strtoupper($_action['action']))
                        ->setSection($section)
                        ->setActionType($defaultActionType)
                        ->setBusinessName($_action['route'])
                        ->setAction(Null)
                        ;
               $list .=   '$this->em->persist('. '$action'.$k .');<br/>'.PHP_EOL;
               $list .=   "     ".PHP_EOL;
             // $this->em->persist($action);

               //dump($action);
                

            }
            $this->em->flush();
        }

        $sectionFromDB = $this->getDoctrine()->getRepository(Section::class)->findAll();
        dump($sectionFromDB);
     
       return $this->renderForm('back/access_control.html.twig', [
        'content' => $list,
    ]);
        // return $this->json('test') ;
    }

   
   
    


}
