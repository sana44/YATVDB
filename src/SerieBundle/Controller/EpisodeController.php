<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\Episode;
use SerieBundle\Form\EpisodeType;

/**
 * Episode controller.
 *
 */
class EpisodeController extends Controller
{

    /**
     * Lists all Episode entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SerieBundle:Episode')->findAll();

        return $this->render('SerieBundle:Episode:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Episode entity.
     *
     */
    public function addEpisodeAction($serieName, $seasonNumber)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name'=>$serieName]);
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(['seasonNumber'=> $seasonNumber,
            'serie'=> $serie]);
        dump($serie->getId()); 
       
        if(!$season){
            throw new NotFoundHttpException("Season not found");
        }
        if(!$serie){
            throw new NotFoundHttpException("Serie not found");
        }   

        $episode = new Episode();
        $episode->setSeason($season);
        $episode->setSerie($serie);
        
        $form=$this->createForm(new EpisodeType(), $episode);
        $request=$this->getRequest();
        $method=$request->getMethod();
        if($method=="POST"){
            $form->bind($request);
            if($form->isValid()){
                $em->persist($episode);
                $em->flush();
                return $this->redirect($this->generateUrl('serie_showSeason', ['name' => $serie->getName(), 'seasonNumber' => $season->getSeasonNumber()]));
            }
            
        }

        return $this->render("SerieBundle:Episode:addEpisode.html.twig", array(
            'form'=>$form->createView(),
            'serie'=>$serie,
            'season'=>$season,
            'episode'=>$episode
        ));
    }

    /**
     * Creates a form to create a Episode entity.
     *
     * @param Episode $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Episode $entity)
    {
        $form = $this->createForm(new EpisodeType(), $entity, array(
            'action' => $this->generateUrl('episode_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Episode entity.
     *
     */
    public function newAction()
    {
        $entity = new Episode();
        $form   = $this->createCreateForm($entity);

        return $this->render('SerieBundle:Episode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Episode entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SerieBundle:Episode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Episode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SerieBundle:Episode:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Episode entity.
     *
     */
    public function editEpisodeAction($serieName,$seasonNumber,$episodeNumber)
    {
        
        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(["name"=>$serieName]);
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(["seasonNumber"=>$seasonNumber]);
        $episode = $em->getRepository('SerieBundle:Episode')->findOneBy(["episodeNumber"=>$episodeNumber]);
        //$episode = $em->getRepository('SerieBundle:Episode')->find($idEpisode);

        if (!$episode) {
            throw $this->createNotFoundException('L\'épisode n\'existe pas');
        }

        $editForm = $this->createEditForm($episode);
        $deleteForm = $this->createDeleteForm($seasonNumber);

        return $this->render('SerieBundle:Episode:edit.html.twig', array(
            'episode'     => $episode,
            'season'      => $season,
            'serie'       => $serie,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Episode entity.
    *
    * @param Episode $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Episode $entity)
    {
        $form = $this->createForm(new EpisodeType(), $entity, array(
            'action' => $this->generateUrl('episode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Episode entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $episode = $em->getRepository('SerieBundle:Episode')->find($id);
        if (!$episode) {
            throw $this->createNotFoundException('Unable to find Episode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($episode);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serie_showSeason', ['name' => $episode->getSerie()->getName(), 'seasonNumber' => $episode->getSeason()->getSeasonNumber()]));
        }

        return $this->render('SerieBundle:Episode:edit.html.twig', array(
            'episode'      => $episode,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Episode entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SerieBundle:Episode')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Episode entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('episode'));
    }

    /**
     * Creates a form to delete a Episode entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('episode_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
