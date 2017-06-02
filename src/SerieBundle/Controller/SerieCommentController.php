<?php

namespace SerieBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\SerieComment;
use Symfony\Component\HttpFoundation\Request;
use SerieBundle\Form\SerieCommentType;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * SerieComment controller.
 *
 */
class SerieCommentController extends Controller
{
  protected $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function get($service)
  {
    return $this->container->get($service);
  }

  public function addCommentAction(Request $request, $serie_id)
  {
    $em = $this->getDoctrine()->getManager();
    $comment = new SerieComment();

    $serie = $em->getRepository('SerieBundle:Serie')->find($serie_id);
    $user = $this->container->get('security.context')->getToken()->getUser();

    $form = $this->createCreateForm($comment, $serie->getId());

    $form->handleRequest($request);

    $method = $request->getMethod();

    if ($method === 'POST'){

      $comment = $form->getData();

      $comment->setSerie($serie);

      $comment->setUser($user);

      $em->persist($comment);
      $em->flush();

    }
    return $this->redirectToRoute('serie_detail', ['name' => $serie->getName()]);
  }

  /**
   * Creates a form to create a SerieComment entity.
   *
   * @param SerieComment $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  public function createCreateForm(SerieComment $entity, $serie_id)
  {
    $form = $this->createForm(new SerieCommentType(), $entity, array(
                                                                     'action' => $this->generateUrl('serie_addComment', ['serie_id' => $serie_id]),
                                                                     'method' => 'POST',
                                                                     ));
    return $form;
  }

}
