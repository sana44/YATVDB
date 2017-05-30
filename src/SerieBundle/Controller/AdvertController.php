<?php

namespace SerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{

  public function translationAction($name)
  {
    return $this->render('SerieBundle:Advert:translation.html.twig', array(
      'name' => $name
    ));
  }
}