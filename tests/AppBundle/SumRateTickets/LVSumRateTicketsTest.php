<?php

namespace LV\ReservationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

class LVSumRateTicketsTest extends WebTestCase 
{
   public function testSetSumRateTickets()
   {
       // Instanciation des objets Command et Ticket 
       $command = new \LV\ReservationBundle\Entity\Command; 
       $ticket = new \LV\ReservationBundle\Entity\Ticket;
       
       // Instanciation de la class LVSumRateTickets
       $sumRateTicket = new \LV\ReservationBundle\SumRateTickets\LVSumRateTickets;
       
       // Initialisation de l'attribut customerBirthDate
       $birthDate = new \DateTime("1970-01-01");
       $ticket->setCustomerBirthDate($birthDate);
       
       // Initialisation d'un objet Ticket
       $command->addTicket($ticket);
       
       // Initialisation de la fonction à tester setSumRateTickets
       $sumRateTicket->setSumRateTickets($command);
       
       // Test de la somme totale de la commande et du nombre de tickets
       $this->assertEquals(16, $command->getSum());
       $this->assertEquals(1, $command->getNumberTickets());
    }
}