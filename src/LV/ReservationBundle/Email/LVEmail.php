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
       
        
       $listTickets = $command->getTickets();
        
       $message = (new \Swift_Message('Commande de billets d\'entrée au musée de Louvre' ))
        ->setFrom('yassir.montet70@gmail.com')
        ->setTo($command->getEmail())
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

