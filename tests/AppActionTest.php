<?php

namespace TomPedals\HelpScoutApp;

use Mockery;
use TomPedals\HelpScoutApp\Exception\InvalidRequestException;
use TomPedals\HelpScoutApp\Exception\InvalidSignatureException;
use TomPedals\HelpScoutApp\Model\Customer;
use TomPedals\HelpScoutApp\Model\Mailbox;
use TomPedals\HelpScoutApp\Model\Ticket;
use TomPedals\HelpScoutApp\Model\User;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class AppActionTest extends \PHPUnit_Framework_TestCase
{
    private $request;
    private $requestFactory;
    private $handler;
    private $action;

    public function setUp()
    {
        $this->request = new AppRequest(
            Customer::create([]),
            Mailbox::create([]),
            Ticket::create([]),
            User::create([])
        );

        $this->requestFactory = Mockery::mock(AppRequestFactory::class, [
            'create' => $this->request,
        ]);

        $this->handler = Mockery::mock(AppHandlerInterface::class);

        $this->action = new AppAction($this->requestFactory, $this->handler);
    }

    public function testRespondsWithForbiddenWhenSignatureIsInvalid()
    {
        $request = new ServerRequest([], [], null, 'POST');

        $this->requestFactory->shouldReceive('create')
            ->andThrow(new InvalidSignatureException());

        $response = $this->action->__invoke($request, new Response());

        $this->assertSame(403, $response->getStatusCode());
        $this->assertSame('{"html":"Signature could not be verified"}', (string) $response->getBody());
    }

    public function testRespondsWithBadRequestWhenJsonCannotBeDecoded()
    {
        $request = new ServerRequest([], [], null, 'POST');

        $this->requestFactory->shouldReceive('create')
            ->andThrow(new InvalidRequestException());

        $response = $this->action->__invoke($request, new Response());

        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('{"html":"Bad request"}', (string) $response->getBody());
    }

    public function testRespondsWithRenderedView()
    {
        $request = new ServerRequest([], [], null, 'POST');

        $this->handler->shouldReceive('handle')
            ->with($this->request)
            ->andReturn('<h4>Test</h4>')
            ->once();

        $response = $this->action->__invoke($request, new Response());

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('{"html":"<h4>Test<\/h4>"}', (string) $response->getBody());
    }
}
