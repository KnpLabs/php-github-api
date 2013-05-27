<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\Exception\InvalidArgumentException;
use Github\HttpClient\HttpClient;
use Github\HttpClient\HttpClientInterface;

class ResultPaginator
{
    protected $client;
    protected $apiClass;

    protected $pagination = null;

    public function __construct( Client $client ) {
        $this->client = $client;
    }

    public function fetchAll( ApiInterface $api, $method, $parameters ) {
        $result = array();
        $result = call_user_func_array( array($api,$method), $parameters);
        $this->postFetch();

        while ($this->hasNext()) {
            $result = array_merge($result, $this->fetchNext());
        }
        return $result;
    }

    protected function postFetch() {
        $this->pagination = $this->client->getHttpClient()->getLastResponse()->getPagination();
        var_dump($this->pagination);
    }

    public function fetchNext() {
        $result = $this->client->getHttpClient()->get($this->pagination['next']);
        $this->postFetch();
        return $result->getContent();
    }

    public function hasNext() {
        if (!empty($this->pagination) and isset($this->pagination['next'])) {
            return true;
        }
        return false;
    }

    public function hasPrevious() {
        if (!empty($this->pagination) and isset($this->pagination['previous'])) {
            return true;
        }
        return false;
    }

}
