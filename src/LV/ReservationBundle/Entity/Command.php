<?php

namespace LV\ReservationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * command
 *
 * @ORM\Table(name="lv_command")
 * @ORM\Entity(repositoryClass="LV\ReservationBundle\Repository\CommandRepository")
 */
class Command
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="sum", type="integer")
     */
    private $sum;

    /**
     * @var int
     *
     * @ORM\Column(name="number_tickets", type="integer")
     */
    private $numberTickets = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="booking_code", type="string", length=255)
     */
    private $bookingCode;
    
    /**
    * @ORM\OneToMany(targetEntity="LV\ReservationBundle\Entity\Ticket", mappedBy="command",cascade={"persist"})
    */
    private $tickets; // une commande est liée à plusieurs tickets

    
    public function __construct() {
        $this->date = new \DateTime();
        $this->tickets = new ArrayCollection();
    }
    
   /**
   * @ORM\PreUpdate
   */
    public function increaseTicket()
    {
        $this->numberTickets++;
    }

    public function decreaseTicket()
    {
        $this->numberTickets--;
    }
 
    /**
    * @param Ticket $ticket
    */
    public function addTicket(Ticket $ticket)
    {
        //$this->tickets[] = $ticket;
        // ou cette syntaxe
        $this->tickets->add($ticket);
        // On lie la commande au billet
        $ticket->setCommand($this);
        
    }

   /**
   * @param Ticket $ticket
   */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
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
     * @return command
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set sum.
     *
     * @param int $sum
     *
     * @return command
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum.
     *
     * @return int
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set numberTickets.
     *
     * @param int $numberTickets
     *
     * @return command
     */
    public function setNumberTickets($numberTickets)
    {
        $this->numberTickets = $numberTickets;

        return $this;
    }

    /**
     * Get numberTickets.
     *
     * @return int
     */
    public function getNumberTickets()
    {
        return $this->numberTickets;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return command
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set bookingCode.
     *
     * @param string $bookingCode
     *
     * @return command
     */
    public function setBookingCode($bookingCode)
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    /**
     * Get bookingCode.
     *
     * @return string
     */
    public function getBookingCode()
    {
        return $this->bookingCode;
    }
    
    /**
    * @return ArrayCollection
    */
     public function getTickets()
     {
        return $this->tickets;
     }
     
}
