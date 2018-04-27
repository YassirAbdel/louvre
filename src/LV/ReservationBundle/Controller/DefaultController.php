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
            if ($numberTickets < 2)    
            {
                // Appel du service sumratetickets et récupération de la somme totale de la commande et du nombre de tickets
                $sumTicketsNumber = $this->container->get('lv_reservation.sumratetickets')->getSumRateTickets($command->getTickets());
                // Enregistrement de la somme totale de la commande 
                $command->setSum($sumTicketsNumber[0]);
                // Enregistrement du nombre de tickets 
                $command->setNumberTickets($sumTicketsNumber[1]);
                
                $em->persist($command);
                $em->flush();
                $request->getSession()->getFlashBag()->add('commande', 'Votre commande a été validée. Merci de procéder au paiement');
                
                return $this->redirectToRoute('lv_Commande_view',array('id' => $command->getId())); 
                
            }
            // Condition : si la capacité du musée est dépassée
            else 
            {
                $request->getSession()->getFlashBag()->add('billetsmax', 'Plus de billets disponible pour ce jour. La commande n\'a pas été enregistrée');
                return $this->render('LVReservationBundle:Command:max.html.twig');
            }
            
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
            $em = $this->getDoctrine()->getManager();
            $command = $em->getRepository('LVReservationBundle:Command')->find($request->query->get('id'));

            if (null === $command) {
              throw new NotFoundHttpException("La commande numéro ".$id." n'existe pas.");
            }

            // Récupération de la liste des billets de la commande
            $listTickets = $em
              ->getRepository('LVReservationBundle:Ticket')
              ->findBy(array('command' => $command))
            ;
            
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
       $command = $em->getRepository('LVReservationBundle:Command')->find($request->query->get('id'));
       $sum = $command->getSum();
       $numberTickets = 'Nombre de billets : ' . $command->getNumberTickets();
       
       
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_600LSdmDPJ6OwrwVoyeNHT64");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        try { 
            $token = $_POST['stripeToken'];
         
            $charge = \Stripe\Charge::create([
            'amount' => $sum * 100,
            'currency' => 'eur',
            'description' => $numberTickets,
            'source' => $request->request->get('stripeToken'),
            ]);
            $request->getSession()->getFlashBag()->add('success','Paiement réussi !');
        } catch (Exception $ex) {
            $request->getSession()->getFlashBag()->add('error','Paiement échoué !');
        }
        // Appel service lv_reservation.email pour envoyer une email de confirmation
        $this->container->get('lv_reservation.email')->sendNotificationCommand($command);
        return $this->render('LVReservationBundle:Command:paiement.html.twig');
        
    }
    
    
}
