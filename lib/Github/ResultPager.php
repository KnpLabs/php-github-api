<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\HttpClient;
use Github\HttpClient\HttpClientInterface;

/**
 * Pager class for supporting pagination in github classes
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
class ResultPager implements ResultPagerInterface
{
    /**
     * @var Github\Client client
     */
    protected $client;

    /**
     * @var array pagination
     * Comes from pagination headers in Github API results
     */
    protected $pagination = null;

    public function __construct( Client $client )
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch( ApiInterface $api, $method )
    {
        $parameters = array_slice(func_get_args(),2);

        $result = call_user_func_array(array($api, $method), $parameters);
        $this->postFetch();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll( ApiInterface $api, $method )
    {
        $parameters = array_slice(func_get_args(),2);

        // Set parameters per_page to GitHub max to minimize number of requests
        $api->setPerPage(100);

        $result = array();
        $result = call_user_func_array(array($api, $method), $parameters);
        $this->postFetch();

        while ($this->hasNext()) {
            $result = array_merge($result, $this->fetchNext());
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function postFetch()
    {
        $this->pagination = $this->client->getHttpClient()->getLastResponse()->getPagination();
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
        if (!empty($this->pagination) and isset($this->pagination[$key])) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function get($key)
    {
        if ( $this->has($key) ) {
            $result = $this->client->getHttpClient()->get($this->pagination[$key]);
            $this->postFetch();

            return $result->getContent();
        }
    }

}
