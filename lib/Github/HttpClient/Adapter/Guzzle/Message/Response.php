<?php

namespace Github\HttpClient\Adapter\Guzzle\Message;

use Guzzle\Http\Message\Response as GuzzleResponse;
use Github\HttpClient\Message\AbstractResponse;

class Response extends AbstractResponse
{
    /** @var GuzzleResponse */
    private $response;

    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawBody()
    {
        return $this->response->getBody(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderAsString($name)
    {
        return $this->response->getHeader($name, true);
    }

    /**
     * {@inheritdoc}
     *
     * @return GuzzleResponse
     */
    public function getAdapterResponse()
    {
        return $this->response;
    }
}
