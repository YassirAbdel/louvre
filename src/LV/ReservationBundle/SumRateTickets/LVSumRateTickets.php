<?php

namespace LV\ReservationBundle\SumRateTickets;


class LVSumRateTickets
{
    /**
     * 1. Ajouter le tarif et type du tarif d'un billet
     * 2. Calculer le coût totale et le nombre des billets
     */
    
    public function getSumRateTickets ($tickets)
    { 
        $commandSum = 0;
        $ticketNumber = 0;
        foreach ($tickets as $ticket)
            {
                
                $ticket->sumTickets();
                $ticketRate = $ticket->getTicketRate();
                $commandSum = $commandSum + $ticketRate;
                $ticketNumber = $ticketNumber + 1;
                
            }
           return $sumTicketsNumber = array($commandSum, $ticketNumber);
    }
}



