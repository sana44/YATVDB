<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
     * Creates a new Season entity.
     *
     */
    public function addSeasonAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name'=>$name]);

        $season = new Season();
        $season->setSerie($serie);
        $form=$this->createCreateForm($season);
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
            'action' => $this->generateUrl('serie_addSeason', ['name' => $entity->getSerie()->getName()]),
            'method' => 'POST',
        ));

        $form->add('seasonNumber');

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
        $serie = $em->getRepository('SerieBundle:Serie')->findOneBy(['name' => $name]);
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(['seasonNumber'=>$seasonNumber,
                                                                       'serie' => $serie]);

        if (!$season) {
            throw $this->createNotFoundException('Unable to find Season entity.');
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
            'action' => $this->generateUrl('season_update',
                                           array('serie_id' => $entity->getSerie()->getId(),
                                                 'season_number' => $entity->getSeasonNumber())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Season entity.
     *
     */
    public function updateAction(Request $request, $serie_id, $season_number)
    {

        $em = $this->getDoctrine()->getManager();

        $serie = $em->getRepository('SerieBundle:Serie')->find($serie_id);
        if(!$serie){
            throw $this->createNotFoundException('Unable to find serie entity.');
        }
        $season = $em->getRepository('SerieBundle:Season')->findOneBy(['seasonNumber'=>$season_number,
                                                                       'serie' => $serie]);
        if(!$season){
            throw $this->createNotFoundException('Unable to find season entity.');
        }

        $deleteForm = $this->createDeleteForm($season->getId());
        $editForm = $this->createEditForm($season);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('serie_showSeason',
                                                      array('name' => $season->getSerie()->getName(),
                                                            'seasonNumber'=> $season->getSeasonNumber())));
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
    public function deleteSeasonAction(Request $request, $seasonId)
    {
        $em=$this->getDoctrine()->getManager();
        $season=$em->getRepository("SerieBundle:Season")->find($seasonId);

        if(!$season){
            throw new NotFoundHttpException("Aucune saison trouvée");
        }

        $em->remove($season);
        $em->flush();

        return $this->redirect($this->generateUrl('serie_detail',['name' => $season->getSerie()->getName()]));
    }

    /**
     * Creates a form to delete a Season entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($seasonId)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('season_delete', array('seasonId' => $seasonId)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
