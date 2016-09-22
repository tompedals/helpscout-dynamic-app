<?php

namespace TomPedals\HelpScoutApp;

use Psr\Http\Message\ServerRequestInterface;
use TomPedals\HelpScoutApp\Exception\InvalidRequestException;
use TomPedals\HelpScoutApp\Exception\InvalidSignatureException;
use TomPedals\HelpScoutApp\Model\Customer;
use TomPedals\HelpScoutApp\Model\Mailbox;
use TomPedals\HelpScoutApp\Model\Ticket;
use TomPedals\HelpScoutApp\Model\User;

class DynamicAppRequestFactory
{
    const SIGNATURE_HEADER = 'X-HelpScout-Signature';

    /**
     * @param string
     */
    private $secretKey;

    /**
     * @param string $secretKey
     */
    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return DynamicAppRequest
     */
    public function create(ServerRequestInterface $request)
    {
        $data = $this->decodeJsonBody($request);
        $this->verifySignature($request);

        return new DynamicAppRequest(
            Customer::create(isset($data['customer']) ? $data['customer'] : []),
            Mailbox::create(isset($data['mailbox']) ? $data['mailbox'] : []),
            Ticket::create(isset($data['ticket']) ? $data['ticket'] : []),
            User::create(isset($data['user']) ? $data['user'] : [])
        );
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return array JSON decoded data
     *
     * @throws InvalidRequestException
     */
    private function decodeJsonBody(ServerRequestInterface $request)
    {
        $data = json_decode((string) $request->getBody(), true);
        if ($data === null) {
            throw new InvalidRequestException('The request JSON body could not be decoded');
        }

        return $data;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @throws InvalidSignatureException
     */
    private function verifySignature(ServerRequestInterface $request)
    {
        $signature = base64_encode(hash_hmac('sha1', (string) $request->getBody(), $this->secretKey, true));

        if ($request->getHeaderLine(self::SIGNATURE_HEADER) !== $signature) {
            throw new InvalidSignatureException('The request signature was invalid');
        }
    }
}
