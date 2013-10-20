<?php

namespace Github\HttpClient;

use Github\HttpClient\RequestInterface;
use Github\HttpClient\ResponseInterface;

abstract class AbstractAdapter implements HttpClientInterface
{
    /**
     * @var RequestInterface
     */
    protected $lastRequest;

    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var array
     */
    protected $options = array(
        'base_url'    => 'https://api.github.com/',
        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
        'timeout'     => 10,
        'api_version' => 'beta',
        'cache_dir'   => null
    );
    /**
     * @var array
     */
    protected $headers;

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function clearHeaders()
    {
        $this->headers = array(
            sprintf('Accept: application/vnd.github.%s+json', $this->options['api_version'])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * {@inheritDoc}
     */
    public function getAPILimit()
    {
        if (!$this->getLastRequest()) {
            $this->get('/rate_limit');
        }

        return (int) $this->getLastRequest()->getHeaderAsString('X-RateLimit-Limit');
    }

    /**
     * {@inheritDoc}
     */
    public function getAPIRemaining()
    {
        if (!$this->getLastRequest()) {
            $this->get('/rate_limit');
        }

        return (int) $this->getLastRequest()->getHeaderAsString('X-RateLimit-Remaining');
    }
}
