<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SerieBundle\Entity\Serie;
use SerieBundle\Entity\SerieComment;
use SerieBundle\Form\SerieType;

/**
 * Serie controller.
 *
 */
class SerieController extends Controller
{

    /**
     * Lists all Serie entities.
     *
     */
    public function showSerieDetailAction($name)
    {
        $SerieCommentController = $this->get('SerieCommentController');
        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name' => $name]);

        if (!$serie) {
            throw $this->createNotFoundException('Cette série n\'existe pas');
        }
        $serieCommentForm = $SerieCommentController->createCreateForm(new SerieComment, $serie->getId());

        return $this->render('SerieBundle:Serie:detailSerie.html.twig', array(
            'serie' => $serie,
            'serieCommentForm' => $serieCommentForm->createView()
        ));
    }

    /**
     * Creates a form to create a Serie entity.
     *
     * @param Serie $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Serie $entity)
    {
        $form = $this->createForm(new SerieType(), $entity, array(
            'action' => $this->generateUrl('serie_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Serie entity.
     *
     */
    public function addSerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->findAll();
        
        $serie = new Serie();
        
        $form=$this->createForm(new SerieType(), $serie);
        $request=$this->getRequest();
        $method=$request->getMethod();
        if($method=="POST"){
            $form->bind($request);
            if($form->isValid()){
                $em->persist($serie);
                $em->flush();
                return $this->redirect($this->generateUrl('serie_detail', ['name' => $serie->getName()]));
            }  
        }
        

        return $this->render("SerieBundle:Serie:new.html.twig", array(
            'form'=>$form->createView(),
            'serie'=>$serie
        ));
    }

    /**
     * Displays a form to edit an existing Serie entity.
     *
     */
    public function editSerieAction($id)
    {
       

        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->find($id);
        
        /*$serie -> getImage() -> newDateTime();*/
        
        if (!$serie) {
            throw $this->createNotFoundException('La série n\'existe pas');
        }

        $editForm = $this->createEditForm($serie);
        $deleteForm = $this->createDeleteForm($id);

        /*$serie -> getImage() -> setUrl('test.png');
        $serie -> getImage() -> newDateTime();*/

        return $this->render('SerieBundle:Serie:edit.html.twig', array(
            'serie'      => $serie,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /*public function modifierImageAction($id_article)
    {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'article
    $serie = $em->getRepository('SerieBundle:Serie')->find($id_article);

    // On modifie l'URL de l'image par exemple
    $serie->getImage()->setUrl('test.png');


    // On déclenche la modification
    $em->flush();

    return new Response('OK');
    }*/



    /**
    * Creates a form to edit a Serie entity.
    *
    * @param Serie $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Serie $entity)
    {
        $form = $this->createForm(new SerieType(), $entity, array(
            'action' => $this->generateUrl('serie_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Deletes a Serie entity.
     *
     */
    public function deleteSerieAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $serie=$em->getRepository("SerieBundle:Serie")->find($id);

        if(!$serie){
            throw new NotFoundHttpException("Aucune série trouvée");
        }

        $em->remove($serie);
        $em->flush();

        return $this->redirect($this->generateUrl('serie_showCategory',['name' => $serie->getCategory()->getName()]));
    }

    /**
     * Creates a form to delete a Serie entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('serie_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Edits an existing Serie entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Unable to find Serie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($serie);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serie_detail', array('name' => $serie->getName())));
        }

        return $this->render('SerieBundle:Serie:edit.html.twig', array(
            'serie'      => $serie,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function addCommentAction(Request $request, $serie_id)
    {
      $SerieCommentController = $this->get('SerieCommentController');

      $SerieCommentController->addCommentAction($request, $serie_id);

      $em = $this->getDoctrine()->getManager();

      $serie = $em->getRepository('SerieBundle:Serie')->find($serie_id);
      return $this->redirectToRoute('serie_detail', ['name' => $serie->getName()]);
    }

}
