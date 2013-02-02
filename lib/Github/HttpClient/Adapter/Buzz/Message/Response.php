<?php

namespace Github\HttpClient\Adapter\Buzz\Message;

use Buzz\Message\Response as BuzzResponse;
use Github\HttpClient\Message\AbstractResponse;

class Response extends AbstractResponse
{
    /** @var BuzzResponse */
    private $response;

    public function __construct(BuzzResponse $response)
    {
        $this->response = $response;
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
        return $this->response->getHeader($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isNotModified()
    {
        return 304 === $this->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapterResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     *
     * @return BuzzResponse
     */
    public function getRawBody()
    {
        return $this->response->getContent();
    }
}
