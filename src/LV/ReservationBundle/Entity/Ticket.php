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
     * @var string
     *
     * @ORM\Column(name="ticket_type", type="string", length=255)
     */
    private $ticketType;

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
     * Set ticketType.
     *
     * @param string $ticketType
     *
     * @return Ticket
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    /**
     * Get ticketType.
     *
     * @return string
     */
    public function getTicketType()
    {
        return $this->ticketType;
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
}
