<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\Serie;
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
        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name' => $name]);

        if (!$serie) {
            throw $this->createNotFoundException('Cette série n\'existe pas');
        }

    
        return $this->render('SerieBundle:Serie:detailSerie.html.twig', array(
            'serie' => $serie,

        ));
    }
    /**
     * Creates a new Serie entity.
     * 
     */
    public function createAction(Request $request)
    {
        $entity = new Serie();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('serie_detail', array('name' => $entity->getName())));
        }

        return $this->render('SerieBundle:Serie:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
    public function newSerieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->find($id);
        if(!$serie){
            $serie = new Serie();
        }
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

        if (!$serie) {
            throw $this->createNotFoundException('Unable to find Serie entity.');
        }

        $editForm = $this->createEditForm($serie);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SerieBundle:Serie:edit.html.twig', array(
            'serie'      => $serie,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

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
        $categoryName=$serie->getCategory()->getName();
        if($serie){
            $id=$serie->getId();
        }
        $request=$this->getRequest();
        $method=$request->getMethod();
        
        if($method=='POST'){
            if($id!=0){
                $em->remove($serie);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('serie_showCategory', array('name' => $categoryName))
            );  
        }
        return $this->render('SerieBundle:Default:serieList.html.twig', array(
            'category'=>$serie->getCategory(),
        ));
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

        $entity = $em->getRepository('SerieBundle:Serie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Serie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serie_edit', array('id' => $id)));
        }

        return $this->render('SerieBundle:Serie:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
<<<<<<< HEAD
    /**
     * Deletes a Serie entity.
     *
     */
    public function deleteSerieAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SerieBundle:Serie')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Serie entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('serie_showCategory'));
       
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


=======
    
>>>>>>> 6a02ce2ff1c3b8f556e52299b1de9e109106550c
}
