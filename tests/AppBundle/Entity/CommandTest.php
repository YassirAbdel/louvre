<?php

namespace LV\ReservationBundle\Tests\Entity;

use LV\ReservationBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * {@inheritDoc}
     */
    
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    
    /*public function testbookingWrongValidator()
    {
        $command = new \LV\ReservationBundle\Entity\Command; 
        $bookingDate = new \DateTime("2018-05-12");
        $ticketType = "Journée";
        $command->setBookingDate($bookingDate);
        $command->setTicketsType($ticketType);
        
        $validator = $this->createClient()->getContainer()->get('validator');
        $errors = $validator->validate($command);
        
        $this->assertEquals(1, count($errors));
        
    }*/
    
     public function testbookingGoodValidator()
    {
        $validator = $this->createClient()->getContainer()->get('validator');
        
        $command = new \LV\ReservationBundle\Entity\Command; 
        $bookingDate = new \DateTime("2018-05-12");
        $ticketType = "Journée";
        $command->setBookingDate($bookingDate);
        $command->setTicketsType($ticketType);
        $errors = $validator->validate($command);
        
        $this->assertEquals(1, count($errors));
        $command->setEmail('toto@gmail.com');
        
        $errors = $validator->validate($command);
        
        
        $this->assertEquals(0, count($errors));
        
    }
}

