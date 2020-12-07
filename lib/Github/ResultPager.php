<?php

namespace Github;

use Github\Api\AbstractApi;
use Github\Api\ApiInterface;
use Github\HttpClient\Message\ResponseMediator;

/**
 * Pager class for supporting pagination in github classes.
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
class ResultPager implements ResultPagerInterface
{
    /**
     * The default number of entries to request per page.
     *
     * @var int
     */
    private const PER_PAGE = 100;

    /**
     * The GitHub Client to use for pagination.
     *
     * @var \Github\Client
     */
    protected $client;

    /**
     * Comes from pagination headers in Github API results.
     *
     * @var array
     */
    protected $pagination;

    /** @var int */
    private $perPage;

    /**
     * The Github client to use for pagination.
     *
     * This must be the same instance that you got the Api instance from.
     *
     * Example code:
     *
     * $client = new \Github\Client();
     * $api = $client->api('someApi');
     * $pager = new \Github\ResultPager($client);
     *
     * @param \Github\Client $client
     */
    public function __construct(Client $client, int $perPage = null)
    {
        $this->client = $client;
        $this->perPage = $perPage ?? self::PER_PAGE;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(ApiInterface $api, $method, array $parameters = [])
    {
        $paginatorPerPage = $this->perPage;
        $closure = \Closure::bind(function (ApiInterface $api) use ($paginatorPerPage) {
            $clone = clone $api;

            if (null !== $api->getPerPage()) {
                @trigger_error(sprintf('Setting the perPage value on an api class is deprecated sinc 2.18 and will be removed in 3.0. Pass the desired items per page value in the constructor of "%s"', __CLASS__), E_USER_DEPRECATED);

                return $clone;
            }

            /* @phpstan-ignore-next-line */
            $clone->perPage = $paginatorPerPage;

            return $clone;
        }, null, AbstractApi::class);

        $api = $closure($api);
        $result = $this->callApi($api, $method, $parameters);

        $this->postFetch();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(ApiInterface $api, $method, array $parameters = [])
    {
        return iterator_to_array($this->fetchAllLazy($api, $method, $parameters));
    }

    public function fetchAllLazy(ApiInterface $api, string $method, array $parameters = []): \Generator
    {
        $result = $this->fetch($api, $method, $parameters);

        foreach ($result['items'] ?? $result as $item) {
            yield $item;
        }

        while ($this->hasNext()) {
            $result = $this->fetchNext();

            foreach ($result['items'] ?? $result as $item) {
                yield $item;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function postFetch()
    {
        $this->pagination = ResponseMediator::getPagination($this->client->getLastResponse());
    }

    /**
     * {@inheritdoc}
     */
    public function hasNext()
    {
        return $this->has('next');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchNext()
    {
        return $this->get('next');
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrevious()
    {
        return $this->has('prev');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchPrevious()
    {
        return $this->get('prev');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchFirst()
    {
        return $this->get('first');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchLast()
    {
        return $this->get('last');
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function has($key)
    {
        return !empty($this->pagination) && isset($this->pagination[$key]);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    protected function get($key)
    {
        if ($this->has($key)) {
            $result = $this->client->getHttpClient()->get($this->pagination[$key]);
            $this->postFetch();

            return ResponseMediator::getContent($result);
        }

        return [];
    }

    /**
     * @deprecated since 2.18 and will be removed in 3.0.
     *
     * @param ApiInterface $api
     * @param string       $method
     * @param array        $parameters
     *
     * @return mixed
     */
    protected function callApi(ApiInterface $api, $method, array $parameters)
    {
        return call_user_func_array([$api, $method], $parameters);
    }
}
