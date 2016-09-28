<?php

namespace TomPedals\HelpScoutApp;

use Psr\Http\Message\ServerRequestInterface;
use TomPedals\HelpScoutApp\Exception\InvalidRequestException;
use TomPedals\HelpScoutApp\Exception\InvalidSignatureException;
use TomPedals\HelpScoutApp\Model\Customer;
use TomPedals\HelpScoutApp\Model\Mailbox;
use TomPedals\HelpScoutApp\Model\Ticket;
use TomPedals\HelpScoutApp\Model\User;

class AppRequestFactory
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
     * @return AppRequest
     */
    public function create(ServerRequestInterface $request)
    {
        $body = (string) $request->getBody();
        $data = $this->decodeJsonBody($body);
        $this->verifySignature($body, $request->getHeaderLine(self::SIGNATURE_HEADER));

        return new AppRequest(
            Customer::create(isset($data['customer']) ? $data['customer'] : []),
            Mailbox::create(isset($data['mailbox']) ? $data['mailbox'] : []),
            Ticket::create(isset($data['ticket']) ? $data['ticket'] : []),
            User::create(isset($data['user']) ? $data['user'] : [])
        );
    }

    /**
     * @param string $body
     *
     * @return array JSON decoded data
     *
     * @throws InvalidRequestException
     */
    private function decodeJsonBody($body)
    {
        $data = json_decode($body, true);
        if ($data === null) {
            throw new InvalidRequestException('The request JSON body could not be decoded');
        }

        return $data;
    }

    /**
     * @param string $body
     * @param string $signature
     *
     * @throws InvalidSignatureException
     */
    private function verifySignature($body, $signature)
    {
        $expectedSignature = base64_encode(hash_hmac('sha1', $body, $this->secretKey, true));

        if ($signature !== $expectedSignature) {
            throw new InvalidSignatureException('The request signature was invalid');
        }
    }
}
