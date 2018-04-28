<?php

namespace LV\ReservationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// Ajoutez ce use pour le contexte
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\DateTime;


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
    * @ORM\Column(name="booking_date", type="datetime", nullable=false)
    */
    private $bookingDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tickets_type", type="string", length=255)
     */
     private $ticketsType;

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

    
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->bookingDate = new \DateTime();
        $this->tickets = new ArrayCollection();
        $this->setBookingCode();
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
    public function getBookingDate()
    {
        return $this->bookingDate;
    }
    
    /**
    * @param \DateTime $date
    */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;
        return $this;
    }
    
    /**
     * Set ticketType.
     *
     * @param string $ticketType
     *
     * @return Ticket
     */
    public function setTicketsType($ticketsType)
    {
        $this->ticketsType = $ticketsType;

        return $this;
    }

    /**
     * Get ticketType.
     *
     * @return string
     */
    public function getTicketsType()
    {
        return $this->ticketsType;
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
     * @return command
     */
    public function setBookingCode()
    {
        $code = '';
        $pool = array_merge(range(0, 9), range('a', 'z'),range('A', 'Z'));

        for($i=0; $i < 10; $i++) {
        $code .= $pool[mt_rand(0, count($pool) - 1)];
        
        }
        $this->bookingCode = $code;
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
     
     /**
     * @Assert\Callback
     */
     
     // Si la date de la réservation est égale à la date du jour :
     // Contrôler le type de billet par rapport à l'heure de réservation
     public function isContentValid(ExecutionContextInterface $context, $payload)
      {
          $nowDate = date("Y-m-d");
          $nowHour = date("H");
          $bookingDate = date_format($this->getBookingDate(), "Y-m-d");
          $ticketsType = $this->getTicketsType();
          if ($bookingDate == $nowDate)
          {
              if (($ticketsType == "journée") && ($nowHour >= 14))
              {
                  $context
                  ->buildViolation('Le type de billets est invalide car il est trop tard pour réserver des billets d\'une journée.') // message
                  ->atPath('ticketsType') 
                  ->addViolation()
                  ;
              }
          }
      }
     
}
