<?php

namespace Github;

use Github\Api\AbstractApi;
use Github\HttpClient\Message\ResponseMediator;
use ValueError;

/**
 * Pager class for supporting pagination in github classes.
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 * @author Graham Campbell <graham@alt-three.com>
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
     * The client to use for pagination.
     *
     * @var Client
     */
    private $client;

    /**
     * The number of entries to request per page.
     *
     * @var int
     */
    private $perPage;

    /**
     * The pagination result from the API.
     *
     * @var array<string,string>
     */
    private $pagination;

    /**
     * Create a new result pager instance.
     *
     * Example code:
     *
     * $client = new \Github\Client();
     * $api = $client->api('someApi');
     * $pager = new \Github\ResultPager($client);
     *
     * @param Client   $client
     * @param int|null $perPage
     *
     * @return void
     */
    public function __construct(Client $client, int $perPage = null)
    {
        if (null !== $perPage && ($perPage < 1 || $perPage > 100)) {
            throw new ValueError(sprintf('%s::__construct(): Argument #2 ($perPage) must be between 1 and 100, or null', self::class));
        }

        $this->client = $client;
        $this->perPage = $perPage ?? self::PER_PAGE;
        $this->pagination = [];
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(AbstractApi $api, string $method, array $parameters = [])
    {
        $paginatorPerPage = $this->perPage;
        $closure = \Closure::bind(function (AbstractApi $api) use ($paginatorPerPage) {
            $clone = clone $api;
            $clone->perPage = $paginatorPerPage;

            return $clone;
        }, null, AbstractApi::class);

        $api = $closure($api);
        $result = $api->$method(...$parameters);

        $this->postFetch();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(AbstractApi $api, string $method, array $parameters = [])
    {
        return iterator_to_array($this->fetchAllLazy($api, $method, $parameters));
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAllLazy(AbstractApi $api, string $method, array $parameters = [])
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

        return $result;
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
        return isset($this->pagination['next']);
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
        return isset($this->pagination['prev']);
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
     * @return array
     */
    protected function get(string $key)
    {
        if (!isset($this->pagination[$key])) {
            return [];
        }

        $result = $this->client->getHttpClient()->get($this->pagination[$key]);

        $this->postFetch();

        return ResponseMediator::getContent($result);
    }
}
