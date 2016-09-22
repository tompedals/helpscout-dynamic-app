<?php

namespace TomPedals\HelpScoutApp;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TomPedals\HelpScoutApp\Exception\InvalidRequestException;
use TomPedals\HelpScoutApp\Exception\InvalidSignatureException;

class AppAction
{
    /**
     * @var AppRequestFactory
     */
    private $appRequestFactory;

    /**
     * @var AppHandlerInterface
     */
    private $appHandler;

    /**
     * @param AppRequestFactory   $appRequestFactory
     * @param AppHandlerInterface $appHandler
     */
    public function __construct(AppRequestFactory $appRequestFactory, AppHandlerInterface $appHandler)
    {
        $this->appRequestFactory = $appRequestFactory;
        $this->appHandler        = $appHandler;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $appResponse = new AppResponse();

        try {
            $appRequest = $this->appRequestFactory->create($request);
        } catch (InvalidSignatureException $exception) {
            $appResponse->setHtml('Signature could not be verified');

            return $this->respondWithJson($response, $appResponse->getData(), 403);
        } catch (InvalidRequestException $exception) {
            $appResponse->setHtml('Bad request');

            return $this->respondWithJson($response, $appResponse->getData(), 400);
        }

        $appResponse->setHtml($this->appHandler->handle($appRequest));

        return $this->respondWithJson($response, $appResponse->getData(), 200);
    }

    /**
     * @param ResponseInterface $response
     * @param array             $data
     * @param int               $status
     *
     * @return ResponseInterface
     */
    private function respondWithJson(ResponseInterface $response, array $data, $status)
    {
        $body = $response->getBody();
        $body->rewind();
        $body->write(json_encode($data));

        $response = $response->withStatus($status);
        $response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $response;
    }
}
