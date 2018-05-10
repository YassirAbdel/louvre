<?php

namespace LV\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CoreController extends Controller
{
 /**
  * @Route("/", name="home_page")
 */
  public function indexAction()
  {
    
    //return $this->render('LVCoreBundle:Core:index.html.twig');
    return $this->redirectToRoute('reserverBillet');
  }

  
}
