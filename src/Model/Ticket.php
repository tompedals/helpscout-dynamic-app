<?php

namespace TomPedals\HelpScoutApp\Model;

class Ticket
{
    private $id;
    private $number;
    private $subject;

    public function __construct($id, $number, $subject)
    {
        $this->id      = $id;
        $this->number  = $number;
        $this->subject = $subject;
    }

    public static function create(array $data)
    {
        return new self(
            isset($data['id']) ? $data['id'] : null,
            isset($data['number']) ? $data['number'] : null,
            isset($data['subject']) ? $data['subject'] : null
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}
