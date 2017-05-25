<?php

namespace SerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        //$deleteForm = $this->createDeleteForm($id);
        return $this->render('SerieBundle:Default:serieList.html.twig', array(
            //'serie'      => $serie,
            'category'  => $category,
            //'delete_form' => $deleteForm->createView(),

        ));
    }
}
