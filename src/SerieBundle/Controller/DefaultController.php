<?php

namespace SerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SerieBundle\Repository\SerieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //
    }

    /**
     * Lists all category entities.
     *
     */
    public function categoryListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('SerieBundle:SerieCategory')->findAll();

        return $this->render('SerieBundle:Default:seriesGenres.html.twig', array(
            'categories' => $categories,
        ));
    }
    /**
     * Finds and displays a Serie entity.
     *
     */
    public function serieListAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        
        $category = $em->getRepository('SerieBundle:SerieCategory')->findOneBy(['name' => $name]); 
        if (!$category) {
            throw $this->createNotFoundException('Pas de série existante dans cette catégorie');
        }
        return $this->render('SerieBundle:Default:serieList.html.twig', array(
            'category'  => $category,

        ));
    }
    
    /**
     * Find Anything through the header Search bar
     */
    public function globalSearchAction(Request $request)
    {
        $param =  $request->query->get('q');

        $series = $this->getDoctrine()
                ->getRepository('SerieBundle:Serie')
                ->search($param);

        $serieCategories = $this->getDoctrine()
                         ->getRepository('SerieBundle:SerieCategory')
                         ->search($param);

        $seasons = $this->getDoctrine()
                 ->getRepository('SerieBundle:Season')
                 ->search($param);

        $episodes = $this->getDoctrine()
                  ->getRepository('SerieBundle:Episode')
                 ->search($param);

        return $this->render('SerieBundle:Default:searchResults.html.twig', [
            'series'  => $series,
            'seriesCategories' => $serieCategories,
            'seasons' => $seasons,
            'episodes' => $episodes
        ]);
    }
    public function legalNoticeAction()
    {
    	return $this->render('SerieBundle:Default:LegalNotice.html.twig');
    }


    public function languageAction($language)
    {

        // enregistre la langue en session
        //$this->container->get('session')->set('_locale',$language);
        //$request = $this->getRequest();
        //$request->setLocale($language);

        // redirige vers la page courante

        /* dump($language); */
        /* die; */

      if($language !== 'fr' && $language !== 'en'){
        $language = 'fr';
      }

        $url = $this->container->get('request')->headers->get('referer');

        if ($language == 'en') {
            $url2 = explode('/', $url);
            $regex = '#^fr#';
            $url3 = preg_replace($regex, 'en', $url2);
            $url4 = implode('/', $url3);

        }else{
            $url2 = explode('/', $url);
            $regex = '#^en#';
            $url3 = preg_replace($regex, 'fr', $url2);
            $url4 = implode('/', $url3);
        }

        return new RedirectResponse($url4);
    }
}
