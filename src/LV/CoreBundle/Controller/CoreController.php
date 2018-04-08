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
    // On retourne simplement la vue de la page d'accueil
    // L'affichage des 3 dernières annonces utilisera le contrôleur déjà existant dans PlatformBundle
    return $this->render('LVCoreBundle:Core:index.html.twig');

    // La méthode longue $this->get('templating')->renderResponse('...') est parfaitement valable
  }

  
}
