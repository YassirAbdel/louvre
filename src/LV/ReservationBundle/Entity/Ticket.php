<?php

namespace LV\ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Ticket
 *
 * @ORM\Table(name="lv_ticket")
 * @ORM\Entity(repositoryClass="LV\ReservationBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="ticket_date", type="date")
     */
    private $date;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rate_type", type="string", length=255)
     */
    private $rateType;

    /**
     * @var int
     *
     * @ORM\Column(name="ticket_rate", type="integer")
     */
    private $ticketRate;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255)
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_first_name", type="string", length=255)
     */
    private $customerFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_country", type="string", length=255)
     */
    private $customerCountry;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="customer_birth_date", type="date")
     */
    private $customerBirthDate;
    
    /**
     * @ORM\Column(name="reduced_price", type="boolean")
     */
     private $reducedPrice = false;


    /**
    * @ORM\ManyToOne(targetEntity="LV\ReservationBundle\Entity\Command", inversedBy="tickets")
    * @ORM\JoinColumn(nullable=false)
    */
    private $command; // Plusieurs tickets sont liés à une commande
    
    
    public function __construct()
    {
        $date = new \DateTime();
        $this->date = $date;
        
    }
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return ticket
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    
    /**
     * Set rateType.
     *
     * @param string $rateType
     *
     * @return Ticket
     */
    public function setRateType($rateType)
    {
        $this->rateType = $rateType;

        return $this;
    }

    /**
     * Get rateType.
     *
     * @return string
     */
    public function getRateType()
    {
        return $this->rateType;
    }

    /**
     * Set ticketRate.
     *
     * @param int $ticketRate
     *
     * @return Ticket
     */
    public function setTicketRate($ticketRate)
    {
        $this->ticketRate = $ticketRate;

        return $this;
    }

    /**
     * Get ticketRate.
     *
     * @return int
     */
    public function getTicketRate()
    {
        return $this->ticketRate;
    }

    /**
     * Set customerName.
     *
     * @param string $customerName
     *
     * @return Ticket
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName.
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerFirstName.
     *
     * @param string $customerFirstName
     *
     * @return Ticket
     */
    public function setCustomerFirstName($customerFirstName)
    {
        $this->customerFirstName = $customerFirstName;

        return $this;
    }

    /**
     * Get customerFirstName.
     *
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Set customerCountry.
     *
     * @param string $customerCountry
     *
     * @return Ticket
     */
    public function setCustomerCountry($customerCountry)
    {
        $this->customerCountry = $customerCountry;

        return $this;
    }

    /**
     * Get customerCountry.
     *
     * @return string
     */
    public function getCustomerCountry()
    {
        return $this->customerCountry;
    }

    /**
     * Set customerBirthDate.
     *
     * @param Date $customerBirthDate
     *
     * @return Ticket
     */
    public function setCustomerBirthDate($customerBirthDate)
    {
        $this->customerBirthDate = $customerBirthDate;

        return $this;
    }

    /**
     * Get customerBirthDate.
     *
     * @return \Date
     */
    public function getCustomerBirthDate()
    {
        return $this->customerBirthDate;
    }
    
    /**
     * @param bool $reducedPrice
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;
    }
    
    /**
     * return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }
    
    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
        
    }
    
    /**
    * @return Command
    */
    public function getCommand()
    {
        return $this->command;
    }
    
    function sumTickets()
    {
        $dateDay = new \Datetime();
        $birthDate = $this->getCustomerBirthDate();
        $reducedPrice = $this->getReducedPrice();
         
        $interval = $birthDate->diff($dateDay);
        $interval =  $interval->format('%R%a');
        $numberYears = intval($interval/365);
        
        if ($numberYears >= 4 && $numberYears <= 12)
        {
            $ticketRateType[1] = 8;
            $ticketRateType[2] = "Enfant";
        }
        if ($numberYears >= 60)
        {
            $ticketRateType[1] = 12;
            $ticketRateType[2] = "Sénior";
        } 
        if ($numberYears < 4)
        {
            $ticketRateType[1] = 0;
            $ticketRateType[2] = "Bébé";
        }
        if ($numberYears > 12 && $numberYears < 60)
        {
            $ticketRateType[1] = 16 ;
            $ticketRateType[2] = "Normal";
        }
        if ($reducedPrice == 1)
        {
            $ticketRateType[1] = 10 ;
            $ticketRateType[2] = "Tarif réduit";
        }
        
        $ticketRate = $ticketRateType[1];
        $RateType = $ticketRateType[2];
        
        // On ajoute le tarif 
        $this->setTicketRate($ticketRate);
        // On ajoute le type de tarif
        $this->setRateType($RateType);
        //dump($this); die();
        return $ticketRateType;
    }
}
