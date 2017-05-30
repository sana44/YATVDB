<?php

namespace SerieBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\SerieComment;
use Symfony\Component\HttpFoundation\Request;

/**
 * SerieComment controller.
 *
 */
class SerieCommentController extends Controller
{

    public function addCommentAction(Request $request, $serie_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $comment = new SerieComment;
        $serie = $em->getRepository('SerieBundle:Serie')->find($serie_id);
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form = $this->createFormBuilder()
        ->add('content', 'text')
        //->add('score', 'int')
        ->getForm();

        $form->handleRequest($request);

        $method = $request->getMethod();

        if ($method === 'POST'){
        
            $comment = $form->getData();

            $comment->setSerie($serie);

            $comment->setUser($user);
            
            
            //$em->persist($comment);
            //$em->flush();

        }
      return $this->redirectToRoute();
    }
}