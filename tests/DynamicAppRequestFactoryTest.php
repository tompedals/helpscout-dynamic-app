<?php

namespace TomPedals\HelpScoutApp;

use TomPedals\HelpScoutApp\Exception\InvalidRequestException;
use TomPedals\HelpScoutApp\Exception\InvalidSignatureException;
use TomPedals\HelpScoutApp\Model\Customer;
use TomPedals\HelpScoutApp\Model\Mailbox;
use TomPedals\HelpScoutApp\Model\Ticket;
use TomPedals\HelpScoutApp\Model\User;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;

class DynamicAppRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new DynamicAppRequestFactory('secret');
    }

    public function testCreatesReturnsNewRequestWithCustomer()
    {
        $request = $this->factory->create($this->createServerRequest());

        $customer = $request->getCustomer();
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame('95993227', $customer->getId());
        $this->assertSame('Help', $customer->getFirstName());
        $this->assertSame('Scout', $customer->getLastName());
        $this->assertSame('help@helpscout.net', $customer->getEmail());
        $this->assertSame(['help@helpscout.net'], $customer->getEmails());
    }

    public function testCreatesReturnsNewRequestWithMailbox()
    {
        $request = $this->factory->create($this->createServerRequest());

        $mailbox = $request->getMailbox();
        $this->assertInstanceOf(Mailbox::class, $mailbox);
        $this->assertSame('85527', $mailbox->getId());
        $this->assertSame('test@tomgraham.engineer', $mailbox->getEmail());
    }

    public function testCreatesReturnsNewRequestWithTicket()
    {
        $request = $this->factory->create($this->createServerRequest());

        $ticket = $request->getTicket();
        $this->assertInstanceOf(Ticket::class, $ticket);
        $this->assertSame('254562138', $ticket->getId());
        $this->assertSame('1', $ticket->getNumber());
        $this->assertSame('Learning the basics', $ticket->getSubject());
    }

    public function testCreatesReturnsNewRequestWithUser()
    {
        $request = $this->factory->create($this->createServerRequest());

        $user = $request->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(141021, $user->getId());
        $this->assertSame('Tom', $user->getFirstName());
        $this->assertSame('Graham', $user->getLastName());
        $this->assertSame('owner', $user->getRole());
        $this->assertSame(0, $user->getConvRedirect());
    }

    public function testCreateThrowsInvalidRequestExceptionWhenJsonCannotBeDecoded()
    {
        $this->expectException(InvalidRequestException::class);

        $request = new ServerRequest([], [], null, 'POST', $this->createStream('!!'));

        $this->factory->create($request);
    }

    public function testCreateThrowsInvalidRequestExceptionWhenSignatureIsInvalid()
    {
        $this->expectException(InvalidSignatureException::class);

        $request = new ServerRequest([], [], null, 'POST', $this->createStream('{}'));
        $request = $request->withHeader(DynamicAppRequestFactory::SIGNATURE_HEADER, 'invalid');

        $this->factory->create($request);
    }

    public function testCreateThrowsInvalidRequestExceptionWhenSignatureIsMissing()
    {
        $this->expectException(InvalidSignatureException::class);

        $request = new ServerRequest([], [], null, 'POST', $this->createStream('{}'));

        $this->factory->create($request);
    }

    private function createServerRequest()
    {
        $body = <<<'JSON'
{
  "ticket": {
    "id": "254562138",
    "number": "1",
    "subject": "Learning the basics"
  },
  "customer": {
    "id": "95993227",
    "fname": "Help",
    "lname": "Scout",
    "email": "help@helpscout.net",
    "emails": [
      "help@helpscout.net"
    ]
  },
  "user": {
    "fname": "Tom",
    "lname": "Graham",
    "id": 141021,
    "role": "owner",
    "convRedirect": 0
  },
  "mailbox": {
    "id": "85527",
    "email": "test@tomgraham.engineer"
  }
}
JSON;

        $request = new ServerRequest([], [], null, 'POST', $this->createStream($body));
        $request = $request->withHeader(DynamicAppRequestFactory::SIGNATURE_HEADER, 'LhgzwysWt/SZpSVvGEii4iTgHLA=');

        return $request;
    }

    private function createStream($string)
    {
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        rewind($stream);

        return new Stream($stream);
    }
}
