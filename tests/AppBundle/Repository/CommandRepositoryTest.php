<?php

namespace LV\ReservationBundle\Tests\Repository;

use LV\ReservationBundle\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommandRepositoryTest extends KernelTestCase
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
    
    public function testgetNumberTickets()
    {
        $bookingDate = new \DateTime("2018-06-13");
        $numberTickets = $this->entityManager
                ->getRepository(Command::class)
                ->getNumberTickets($bookingDate)
        ;
                
        $this->assertEquals(4, $numberTickets);
    }
}
