<?php

namespace LV\ReservationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LV\ReservationBundle\Entity\Command;
use LV\ReservationBundle\Form\CommandType;
use LV\ReservationBundle\Form\TicketType;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{
    /**
     * @Route("/reserver", name="reserverBillet")
     */
    public function addAction(Request $request)
    {
        $form   = $this->get('form.factory')->create(CommandType::class);
        //$formTicket = $this->get('form.factory')->create(TicketType::class);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
           
            $command = $form->getData();
            // Calcul du nombre de billets vendus à la date de réservation
                $numberTickets = $em
                ->getRepository('LVReservationBundle:Command')
                ->getNumberTickets($command->getBookingDate())
                ;
                //dump($numberTickets);die();
            // Condition : si la capacité du musée est inférieure à 1000 billets max le même jour
            if ($numberTickets < 1000) {
                // Appel du service sumratetickets : 
                // 1. ajout du type de tarif d'un billet et du tarif d'un billet 
                // 2. récupération de la somme totale de la commande, du nombre des billets
                $sumTicketsNumber = $this->container->get('lv_reservation.sumratetickets')->setSumRateTickets($command);
                $em->persist($command);
                $request->getSession()->set('command', $command);
                $request->getSession()->getFlashBag()->add('commande', 'Votre commande a été validée. Merci de procéder au paiement');
                
                return $this->redirectToRoute('lv_Commande_view',array('id' => $command->getId())); 
                
            }
            // Sinon : si la capacité du musée est dépassée
                $request->getSession()->getFlashBag()->add('billetsmax', 'Plus de billets disponible pour ce jour. La commande n\'est pas possible');
                return $this->render('LVReservationBundle:Command:max.html.twig');
         }
        return $this->render('LVReservationBundle:Command:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/view", name="lv_Commande_view")
     */
    
        public function viewAction(Request $request)
          {
            $command = $request->getSession()->get('command');
            $listTickets = $command->getTickets();

            if (null === $command) {
              throw new NotFoundHttpException("La commande numéro " . " n'existe pas.");
            }
           
            return $this->render('LVReservationBundle:Command:view.html.twig', array(
              'command'           => $command,
              'listTickets' => $listTickets,
            ));
          }
          
    /**
     * @Route("/paiement", name="lv_payer_Commande")
     */
    
    function paiementAction (Request $request) 
    {
       $em = $this->getDoctrine()->getManager();
       
       $command = $request->getSession()->get('command');
       $listTickets = $command->getTickets();
       $sum = $command->getSum();
       $numberTickets = 'Nombre de billets : ' . $command->getNumberTickets();
       
       \Stripe\Stripe::setApiKey("sk_test_600LSdmDPJ6OwrwVoyeNHT64");

        try { 
            $token = $_POST['stripeToken'];
         
            $charge = \Stripe\Charge::create([
            'amount' => $sum * 100,
            'currency' => 'eur',
            'description' => $numberTickets,
            'source' => $request->request->get('stripeToken'),
            ]);
            $request->getSession()->getFlashBag()->add('success','Paiement réussi !');
            
            // Enregistrement de la commande après le paiement
            $em->persist($command);
            $em->flush();
        
            // Appel service lv_reservation.email pour envoyer une email de confirmation
            $this->container->get('lv_reservation.email')->sendNotificationCommand($command);
        } catch (Exception $ex) {
            $request->getSession()->getFlashBag()->add('error','Paiement échoué !');
        }
        
        return $this->render('LVReservationBundle:Command:paiement.html.twig');
        
    }
    
    
}
