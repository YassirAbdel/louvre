<?php

namespace LV\ReservationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\ReservationBundle\Entity\Command;
use LV\ReservationBundle\Form\CommandType;

class DefaultController extends Controller
{
    /**
     * @Route("/reserver", name="reserverBillet")
     */
    public function addAction(Request $request)
    {
        $command = new \LV\ReservationBundle\Entity\Command;
        $form   = $this->get('form.factory')->create(CommandType::class, $command);
        $command->setSum(10);
        $command->setBookingCode('flgljkbkbkb');
        //$->set
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($command->getTickets() as $ticket)
            {
                $ticket->setTicketRate(10);
            }
            $em->persist($command);
            
            $em->flush();

            $request->getSession()->getFlashBag()->add('commande', 'Nouvelle commande enregistrée.');

            //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('LVReservationBundle:Command:add.html.twig', array(
          'form' => $form->createView(),
        ));
  }
}
