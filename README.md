# HelpScout Dynamic App Server

A simple library to verify [Help Scout dynamic app](http://developer.helpscout.net/custom-apps/dynamic/) requests and respond accordingly. Forked from the [official library](https://github.com/helpscout/helpscout-apps-php) to add support for PSR-7 HTTP message interfaces.

## Installation

This is installable via [Composer](https://getcomposer.org/) as [tompedals/helpscout-dynamic-app](https://packagist.org/packages/tompedals/helpscout-dynamic-app):

    composer require tompedals/helpscout-dynamic-app

## Example

Note: The following example uses zendframework/zend-diactoros as the HTTP message implementation.

### Handle a request

The request will be verified using the given secret and signature from the request headers.

```php
use TomPedals\HelpScoutApp\AppRequestFactory;
use Zend\Diactoros\ServerRequestFactory;

$factory = new AppRequestFactory('secret');
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
use TomPedals\HelpScoutApp\AppResponse;
use Zend\Diactoros\Response\JsonResponse;

$response = new AppResponse('<h4>Test</h4>');
$jsonResponse = new JsonResponse($response->getData());
```

### Controller action

A PSR-7 compatible action is available to handle the request and respond accordingly.
The action is an invokable class that can be used with Slim, Symfony, Zend Framework, etc.

Implement the `AppHandlerInterface` to handle the `AppRequest` and return the HTML to be rendered within the Help Scout sidebar.

```php
class AppHandler implements AppHandlerInterface
{
    public function handle(AppRequest $request)
    {
        // Find customer information
        // Render the template
        // Return the HTML response

        return '<h4>This customer is awesome</h4>';
    }
}
```

Pass the `AppHandler` implementation when constructing the action.

```php
use TomPedals\HelpScoutApp\AppAction;
use TomPedals\HelpScoutApp\AppHandlerInterface;
use TomPedals\HelpScoutApp\AppRequestFactory;

// implements AppHandlerInterface
$handler = new AppHandler();

$action = new AppAction(new AppRequestFactory('secret'), $handler);
$response = $action($request, $response);
```
