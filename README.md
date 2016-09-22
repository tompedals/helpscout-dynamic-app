# HelpScout Dynamic App Server

A simple library to verify [Help Scout dynamic app](http://developer.helpscout.net/custom-apps/dynamic/) requests and respond accordingly.
Forked from the [official library](https://github.com/helpscout/helpscout-apps-php) to add support for PSR-7 HTTP message interfaces.

## Installation

This is installable via [Composer](https://getcomposer.org/) as [tompedals/helpscout-dynamic-app](https://packagist.org/packages/tompedals/helpscout-dynamic-app):

    composer require tompedals/helpscout-dynamic-app

## Example

Note: The following example uses zendframework/zend-diactoros as the HTTP message implementation.

### Handle a request

The request will be verified using the given secret and signature from the request headers.

```php
use TomPedals\HelpScoutApp\DynamicAppRequestFactory;
use Zend\Diactoros\ServerRequestFactory;

$factory = new DynamicAppRequestFactory('secret');
$request = $factory->create(ServerRequestFactory::fromGlobals());

/** @var TomPedals\HelpScoutApp\Model\Customer */
$customer = $request->getCustomer();

/** @var TomPedals\HelpScoutApp\Model\Mailbox */
$mailbox = $request->getMailbox();

/** @var TomPedals\HelpScoutApp\Model\Ticket */
$ticket = $request->getTicket();

/** @var TomPedals\HelpScoutApp\Model\User */
$user = $request->getUser();
```

### Respond to a request

Set the HTML on the response and get the correct schema for the JSON response.

```php
use TomPedals\HelpScoutApp\DynamicAppResponse;
use Zend\Diactoros\Response\JsonResponse;

$response = new DynamicAppResponse('<h4>Test</h4>');
$jsonResponse = new JsonResponse($response->getData());
```
