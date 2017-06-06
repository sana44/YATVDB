<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="root")
     */
    public function redirectAction(Request $request)
    {
        return $this->redirect($this->generateUrl('homepage',['_locale' => 'fr']));
    }
    /**
     * @Route("/{_locale}", name="homepage")
     */
    public function indexAction(Request $request, $_locale)
    {

      $em = $this->getDoctrine()->getManager();
      $lastSeries = $em->getRepository('SerieBundle:Serie')->findBy([], ['releaseDate'=>'DESC'], $limit = 6);

      // replace this example code with whatever you need
      return $this->render('default/index.html.twig', array(
                                                            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
                                                            'lastSeries' => $lastSeries,
                                                            ));
    }
}
