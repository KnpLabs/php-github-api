<?php

namespace Github\HttpClient;

use Http\Adapter\HttpAdapter;
use Github\Factory\RequestFactory;
use Http\Client\HttpClient;

final class HttplugClient implements HttpClientInterface
{
    /** @var HttpAdapter */
    private $adapter;

    /** @var RequestFactory */
    private $factory;

    private $options = array(
        'base_url'    => 'https://api.github.com/',

        'user_agent'  => 'php-github-api (http://github.com/KnpLabs/php-github-api)',

        'api_limit'   => 5000,
        'api_version' => 'v3',

        'cache_dir'   => null
    );

    /**
     * @param HttpAdapter $adapter
     */
    public function __construct(
        HttpClient $adapter,
        RequestFactory $factory
    ) {
        $this->adapter = $adapter;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        return $this->request(
            sprintf(
                '%s/%s?%s',
                rtrim($this->options['base_url'], '/'),
                ltrim($path, '/'),
                http_build_query($parameters)
            ),
            null,
            'GET',
            $headers
        );
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        return $this->request(
            sprintf('%s%s', rtrim($this->options['base_url'], '/'), $path),
            $body,
            'POST',
            $headers
        );
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, $body = null, array $headers = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, $body, array $headers = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, $body = null, array $headers = array())
    {
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, $body, $httpMethod = 'GET', array $headers = array())
    {
        $headers = array_merge([
            'Accept' => sprintf('application/vnd.github.%s+json', $this->options['api_version']),
            'User-Agent' => sprintf('%s', $this->options['user_agent']),
        ], $headers);

        if (null !== $body) {
            $request = $this->factory->createRequest($httpMethod, $path, $headers, $body);
        } else {
            $request = $this->factory->createRequest($httpMethod, $path, $headers);
        }

        // TODO (2016-01-22 14:19 by Gildas): try catch
        return $this->adapter->sendRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($tokenOrLogin, $password, $authMethod)
    {
    }
}
