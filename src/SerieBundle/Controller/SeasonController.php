<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\Season;
use SerieBundle\Form\SeasonType;

/**
 * Season controller.
 *
 */
class SeasonController extends Controller
{

    /**
     * Lists all Season entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SerieBundle:Season')->findAll();

        return $this->render('SerieBundle:Season:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Season entity.
     *
     */
    public function addSeasonAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name'=>$name]);
    
        $season = new Season();
        $season->setSerie($serie);
        $form=$this->createForm(new SeasonType(), $season);
        $request=$this->getRequest();
        $method=$request->getMethod();
        if($method=="POST"){
            $form->bind($request);
            if($form->isValid()){
                $em->persist($season);
                $em->flush();
                return $this->redirect($this->generateUrl('serie_detail', ['name' => $serie->getName()]));
            }
            
        }

        return $this->render("SerieBundle:Season:addSeason.html.twig", array(
            'form'=>$form->createView(),
            'serie'=>$serie,
            'season'=>$season
        ));
    }

    /**
     * Creates a form to create a Season entity.
     *
     * @param Season $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Season $entity)
    {
        $form = $this->createForm(new SeasonType(), $entity, array(
            'action' => $this->generateUrl('season_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function editSeasonAction($serieName, $seasonNumber)
    {
        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(["name"=>$serieName]);
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(["seasonNumber"=>$seasonNumber]);


        if (!$season) {
            throw $this->createNotFoundException('La saison n\'existe pas');
        }

        $editForm = $this->createEditForm($season);
        $deleteForm = $this->createDeleteForm($seasonNumber);

        return $this->render('SerieBundle:Season:edit.html.twig', array(
            'season'      => $season,
            'serie'       => $serie,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Season entity.
     *
     */
    public function showSeasonAction($name, $seasonNumber)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name'=>$name]);
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(['seasonNumber'=>$seasonNumber]);
        if (!$season) {
            throw new NotFoundHttpException('La saison n\'existe pas');
        }

        $deleteForm = $this->createDeleteForm($season->getId());

        return $this->render('SerieBundle:Season:showSeason.html.twig', array(
            'serie'=>$serie,
            'season'      => $season,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Season entity.
    *
    * @param Season $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Season $entity)
    {
        $form = $this->createForm(new SeasonType(), $entity, array(
            'action' => $this->generateUrl('season_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Season entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $season = $em->getRepository('SerieBundle:Season')->find($id);

        if (!$season) {
            throw $this->createNotFoundException('Unable to find Season entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($season);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serie_detail', array('name' => $season->getSerie()->getName())));
        }

        return $this->render('SerieBundle:Season:edit.html.twig', array(
            'season'      => $season,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Season entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SerieBundle:Season')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Season entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('season'));
    }

    /**
     * Creates a form to delete a Season entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('season_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
