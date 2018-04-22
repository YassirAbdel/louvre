<?php

namespace LV\ReservationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\ReservationBundle\Entity\Command;
use LV\ReservationBundle\Form\CommandType;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    /**
     * @Route("/reserver", name="reserverBillet")
     */
    public function addAction(Request $request)
    {
        $command = new \LV\ReservationBundle\Entity\Command;
        $form   = $this->get('form.factory')->create(CommandType::class, $command);
        $bookingDate = $command->getBookingDate();
        $command->setBookingCode('flgljkbkbkb');
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ticketRepo = $this->getDoctrine()
            ->getManager()
            ;
            // Calcul du nombre de billets vendus à la date de réservation
                $numberTickets = $this->getDoctrine()
                ->getManager()
                ->getRepository('LVReservationBundle:Ticket')
                ->numberTickets($command->getBookingDate())
                ;
            // Condition : si la capacité du musée est unférieur à 1000 billets max par raport au jour de réservation
            if ($numberTickets < 1000)    
            {
                // Appel du service lv_reservation.sumratetickets
                $sumRateTickets = $this->container->get('lv_reservation.sumratetickets');
                // Récupération de la somme totale de la commande et du nombre de tickets
                $sumTicketsNumber = $sumRateTickets->getSumRateTickets($command->getTickets());
                // Enregistrement de la somme totale de la commande 
                $command->setSum($sumTicketsNumber[0]);
                // Enregistrement du nombre de tickets 
                $command->setNumberTickets($sumTicketsNumber[1]);
                $em->persist($command);
                $em->flush();
                $request->getSession()->getFlashBag()->add('commande', 'Nouvelle commande enregistrée.');
            }
            // Condition : si la capacité du musée est dépassée
            else 
            {
                $request->getSession()->getFlashBag()->add('billetsmax', 'Plus de billets disponible à ce jour.');
            }
            //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('LVReservationBundle:Command:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
}
