<?php

namespace TomPedals\HelpScoutApp\Model;

class Customer
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $emails = [];

    public function __construct($id, $firstName, $lastName, $email, array $emails)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->emails = $emails;
    }

    public static function create(array $data)
    {
        return new self(
            isset($data['id']) ? $data['id'] : null,
            isset($data['fname']) ? $data['fname'] : null,
            isset($data['lname']) ? $data['lname'] : null,
            isset($data['email']) ? $data['email'] : null,
            isset($data['emails']) ? $data['emails'] : []
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmails()
    {
        return $this->emails;
    }
}
