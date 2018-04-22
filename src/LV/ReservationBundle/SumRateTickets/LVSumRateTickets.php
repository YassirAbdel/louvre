<?php

namespace LV\ReservationBundle\SumRateTickets;


class LVSumRateTickets
{
    /**
     * Calculer le coût total et le nombre des billets
     * Récupérer le type d'un ticket 
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



