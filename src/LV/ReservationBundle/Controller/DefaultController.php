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
        // Enregistrement d'un code aléatoire de la commande de 10 caractères alphanumériques
        // En appellant le service bookingCode
        $command->setBookingCode($this->container->get('lv_reservation.bookingCode')->getRamdomCode(10));
        //OU en utilisant la fonction PHP bin2hex
        //$command->setBookingCode(bin2hex(openssl_random_pseudo_bytes(10)));
        
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
            // Condition : si la capacité du musée est inférieure à 1000 billets max le même jour
            if ($numberTickets < 1000)    
            {
                // Appel du service sumratetickets et récupération de la somme totale de la commande et du nombre de tickets
                $sumTicketsNumber = $this->container->get('lv_reservation.sumratetickets')->getSumRateTickets($command->getTickets());
                // Enregistrement de la somme totale de la commande 
                $command->setSum($sumTicketsNumber[0]);
                // Enregistrement du nombre de tickets 
                $command->setNumberTickets($sumTicketsNumber[1]);
                
                $em->persist($command);
                $em->flush();
                $request->getSession()->getFlashBag()->add('commande', 'Votre commande a été enregistrée. Vous recevrez un Email de confirmation');
                return $this->render('LVReservationBundle:Command:view.html.twig');
            }
            // Condition : si la capacité du musée est dépassée
            else 
            {
                $request->getSession()->getFlashBag()->add('billetsmax', 'Plus de billets disponible à ce jour. La commande n\'a pas été enregistrée');
                return $this->render('LVReservationBundle:Command:view.html.twig');
            }
            //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

        return $this->render('LVReservationBundle:Command:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
}
