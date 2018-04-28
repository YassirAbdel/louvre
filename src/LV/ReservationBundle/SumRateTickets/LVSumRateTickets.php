<?php

namespace LV\ReservationBundle\SumRateTickets;


class LVSumRateTickets
{
    /**
     * 1. Ajouter le tarif et type du tarif d'un billet
     * 2. Calculer le coût totale et le nombre des billets
     */
    
    public function setSumRateTickets ($command)
    { 
        $commandSum = 0;
        $ticketNumber = 0;
        $tickets = $command->getTickets();
        foreach ($tickets as $ticket)
            {
                
                $ticket->sumTickets();
                $ticketRate = $ticket->getTicketRate();
                $commandSum = $commandSum + $ticketRate;
                $ticketNumber = $ticketNumber + 1;
                
            }
            // Enregistrement de la somme totale de la commande 
              $command->setSum($commandSum);
            // Enregistrement du nombre de tickets 
             $command->setNumberTickets($ticketNumber);
            
    }
    
}



