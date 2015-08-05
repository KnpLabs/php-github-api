<?php

namespace Github;

use Github\Api\ApiInterface;
use Github\Api\Search;
use Iterator;

/**
 * The result iterator class.
 *
 * This class allows you to iterate over a large data set with a low memory
 * overhead due to pagination under the hood.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ResultIterator implements Iterator
{
    /**
     * @var \Github\ResultPagerInterface
     */
    protected $pager;

    /**
     * @var \Github\Api\ApiInterface
     */
    protected $api;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var bool
     */
    protected $isSearch;

    /**
     * @var array|null
     */
    protected $results;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $pos = 0;

    /**
     * @param \Github\ResultPagerInterface $pager
     * @param \Github\Api\ApiInterfacev    $api
     * @param string                       $method
     * @param array                        $parameters
     */
    public function __construct(ResultPagerInterface $pager, ApiInterface $api, $method, array $parameters)
    {
        $this->pager = $pager;
        $this->api = $api;
        $this->method = $method;
        $this->parameters = $parameters;
        $this->isSearch = $api instanceof Search;
    }

    /**
     * @return array
     */
    public function current()
    {
        return $this->results[$this->pos - $this->offset];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->pos;
    }

    /**
     * @return void
     */
    public function next()
    {
        ++$this->pos;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->pos = 0;
        $this->offset = 0;
        $this->results = null;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        if ($this->results === null) {
            $this->results = $this->getFirst();
        }

        if (isset($this->results[$this->pos - $this->offset])) {
            return true;
        }

        $this->offset += $this->perPage;
        $this->results = $this->getNext();

        if (isset($this->results[$this->pos - $this->offset])) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getFirst()
    {
        $first = $this->pager->fetch($this->api, $this->method, $this->parameters);

        if ($this->isSearch) {
            return isset($first['items']) ? $first['items'] : $first;
        }

        return $first;
    }

    /**
     * @return array
     */
    protected function getNext()
    {
        if (!$this->pager->hasNext()) {
            return [];
        }

        $next = $this->fetchNext();

        if ($this->isSearch) {
            return isset($next['items']) ? $next['items'] : $next;
        }

        return $next;
    }
}
