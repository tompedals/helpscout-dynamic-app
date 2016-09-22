<?php

namespace TomPedals\HelpScoutApp;

use TomPedals\HelpScoutApp\Model\Customer;
use TomPedals\HelpScoutApp\Model\Mailbox;
use TomPedals\HelpScoutApp\Model\Ticket;
use TomPedals\HelpScoutApp\Model\User;

class AppRequest
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Mailbox
     */
    private $mailbox;

    /**
     * @var Ticket
     */
    private $ticket;

    /**
     * @var User
     */
    private $user;

    /**
     * @param Customer $customer
     * @param Mailbox  $mailbox
     * @param Ticket   $ticket
     * @param User     $user
     */
    public function __construct(Customer $customer, Mailbox $mailbox, Ticket $ticket, User $user)
    {
        $this->customer = $customer;
        $this->mailbox  = $mailbox;
        $this->ticket   = $ticket;
        $this->user     = $user;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Mailbox
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
