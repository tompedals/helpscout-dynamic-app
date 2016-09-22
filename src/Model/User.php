<?php

namespace TomPedals\HelpScoutApp\Model;

class User
{
    const ROLE_USER  = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_OWNER = 'owner';

    private $id;
    private $firstName;
    private $lastName;
    private $role;
    private $convRedirect;

    public function __construct($id, $firstName, $lastName, $role, $convRedirect)
    {
        $this->id           = $id;
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->role         = $role;
        $this->convRedirect = $convRedirect;
    }

    public static function create(array $data)
    {
        return new self(
            isset($data['id']) ? $data['id'] : null,
            isset($data['fname']) ? $data['fname'] : null,
            isset($data['lname']) ? $data['lname'] : null,
            isset($data['role']) ? $data['role'] : null,
            isset($data['convRedirect']) ? $data['convRedirect'] : null
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

    public function getRole()
    {
        return $this->role;
    }

    public function isUser()
    {
        return $this->getRole() === self::ROLE_USER;
    }

    public function isAdmin()
    {
        return $this->getRole() === self::ROLE_ADMIN;
    }

    public function isOwner()
    {
        return $this->getRole() === self::ROLE_OWNER;
    }

    public function getConvRedirect()
    {
        return $this->convRedirect;
    }
}
