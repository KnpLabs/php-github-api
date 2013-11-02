<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\HttpClient\Message\ResponseMediator;

/**
 * Pager class for supporting pagination in github classes
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
class ResultPager implements ResultPagerInterface
{
    /**
     * @var \Github\Client client
     */
    protected $client;

    /**
     * @var array pagination
     * Comes from pagination headers in Github API results
     */
    protected $pagination;

    /**
     * The Github client to use for pagination. This must be the same
     * instance that you got the Api instance from, i.e.:
     *
     * $client = new \Github\Client();
     * $api = $client->api('someApi');
     * $pager = new \Github\ResultPager($client);
     *
     * @param \Github\Client $client
     *
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
    public function fetch(ApiInterface $api, $method, array $parameters = array())
    {
        $result = call_user_func_array(array($api, $method), $parameters);
        $this->postFetch();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(ApiInterface $api, $method, array $parameters = array())
    {
        // get the perPage from the api
        $perPage = $api->getPerPage();

        // Set parameters per_page to GitHub max to minimize number of requests
        $api->setPerPage(100);

        $result = array();
        $result = call_user_func_array(array($api, $method), $parameters);
        $this->postFetch();

        while ($this->hasNext()) {
            $result = array_merge($result, $this->fetchNext());
        }

        // restore the perPage
        $api->setPerPage($perPage);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function postFetch()
    {
        $this->pagination = ResponseMediator::getPagination($this->client->getHttpClient()->getLastResponse());
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
     * {@inheritdoc}
     */
    protected function has($key)
    {
        return !empty($this->pagination) && isset($this->pagination[$key]);
    }

    /**
     * {@inheritdoc}
     */
    protected function get($key)
    {
        if ($this->has($key)) {
            $result = $this->client->getHttpClient()->get($this->pagination[$key]);
            $this->postFetch();

            return ResponseMediator::getContent($result);
        }
    }
}
