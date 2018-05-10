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
    
    public function testbookingDateValidator()
    {
        $command = new \LV\ReservationBundle\Entity\Command; 
        $bookingDate = new \DateTime("2018-05-8");
        $ticketType = "Journée";
        $command->setBookingDate($bookingDate);
        $command->setTicketsType($ticketType);
        
        $validator = $this->createClient()->getContainer()->get('validator');
        $errors = $validator->validate($command, null, ['ContentValid']);
        
        $this->assertEquals(0, count($errors));
        
    }
}

