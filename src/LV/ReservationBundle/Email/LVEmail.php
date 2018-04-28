<?php

// src/LV/Reservation/Email/Mailer.php

namespace LV\ReservationBundle\Email;

use LV\ReservationBundle\Entity\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LVEmail
{
    /*
     * @var \Swift_Mailer
     */
    
    private $mailer;
    private $em;
    private $templating;


    public function __construct(\Swift_Mailer $mailer, $em, $templating) 
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
        
    }
    
    public function sendNotificationCommand($command)
    {
       
        //$em = $this->getDoctrine()->getManager();
            //$command = $em->getRepository('LVReservationBundle:Command')->find($request->query->get('id'));
            //$command = $command->getSession()->get('command');
            $listTickets = $command->getTickets();
        //$idCommand = $command->getId();
        //$commandRepository = $this->em->getRepository('LVReservationBundle:Command');
        //$ticketsRepository = $this->em->getRepository('LVReservationBundle:Ticket');
        
        // Récupération de la commande
        //$command = $commandRepository->find($command->getId());

        //if (null === $command) {
              //throw new NotFoundHttpException("La commande numéro ".$id." n'existe pas.");
        //}

       // Récupération de la liste des billets de la commande
       //$listTickets = $ticketsRepository->findBy(array('command' => $command));
        //dump($command);
        //dump($listTickets);
            //die();
       $message = (new \Swift_Message('Commande de billets d\'entrée au musée de Louvre' ))
        ->setFrom('yassir.montet70@gmail.com')
        ->setTo('yassir.montet@yahoo.fr')
        ->setBody(
            $this->templating->render('LVReservationBundle:Command:command.html.twig', array(
               'command' => $command,
              'listTickets' => $listTickets,
            )
            ),
               
            'text/html'
        );
        try {        
        $this->mailer->send($message);
        }catch (Exception $ex) {
            dump($ex);die();
        }
    }
}

