<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
 
    /**
     * @Route("/swith-locale/{locale}", name="switch_locale")
     */
    public function index($locale, Request $request ): Response
    {
        
        $url = $request->headers->get('referer');
        // dump($url);
        // if(str_contains($url, 'edit')){
        //     $array = explode('/', $url);
        //     $id = $array[count($array)-2]; 
        //     $content = $this->contentRepository->find($id);
        //     dump($id);die;
        //     $aliasOriginLang = $content->getLanguage()->getAlias();
        //     if($aliasOriginLang != $locale){
        //         $article = $content->getArticle();
        //         $langue = $content->getLanguage();
        //         $validContent = $this->contentRepository->findBy(['article'=> $article, 'language' => $langue])[0];
        //         $contentValidId = $validContent->getId();
        //         $validUrl = str_replace('/'.$id.'/', '/'.$contentValidId.'/', $url );
        //         dump($validUrl);
        //     }else{
        //         $validUrl = $url;
        //     }
        // }
        // else{
        //     $validUrl = $url; 
        // }
        
        $request->getSession()->set('_locale', $locale);
        $langs = ['/fr/', '/ar/', '/en/'];
        $newUrl = str_replace($langs, '/'.$locale.'/', $url );
        dump($url, $newUrl);
        //  $newUrl = str_replace('/edit', '/new', $url );
        return $this->redirect($newUrl);
    }
}
