<?php

// src/LV/Reservation/NumberTickets/LVnumberTickets.php

namespace LV\ReservationBundle\NumberTickets;

use LV\ReservationBundle\Entity\Command;

function numberTickets ($date)
{
    $commandRepository = $this->em->getRepository('LVReservationBundle:Command');
    $ticketsRepository = $this->em->getRepository('LVReservationBundle:Ticket');
    
        
        return $this->createQueryBuilder('t')
                ->select('COUNT(t)')
                ->where('c.bookingDate = :date')
                ->setParameter('date', $date)
                ->getQuery()
                ->getSingleScalarResult()
                ;
   
}