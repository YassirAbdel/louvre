<?php

namespace LV\ReservationBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class TicketTest extends WebTestCase
{
   public function testSumTickets()
    {
        $ticket = new \LV\ReservationBundle\Entity\Ticket; 
        $dateDay = new \Datetime();
        $birthDate = new \DateTime("1970-01-01");
        $ticket->setCustomerBirthDate($birthDate);
        $ticket->setReducedPrice("0");
        
        $ticketRateType = $ticket->sumTickets();
        
        $this->assertEquals("Normal", $ticketRateType[2]);
        
    }
}

