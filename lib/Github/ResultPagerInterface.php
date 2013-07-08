<?php

namespace Github;

use Github\Api\ApiInterface;

/**
 * Pager interface
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
interface ResultPagerInterface
{
    /**
     * Fetch a single result (page) from an api call
     */
    public function fetch( ApiInterface $api, $method );

    /**
     * Fetch all results (pages) from an api call
     * Use with care - there is no maximum
     */
    public function fetchAll( ApiInterface $api, $method );

    /**
     * Method that performs the actual work to refresh the pagination property
     */
    public function postFetch();

    /**
     * Check to determine the availability of a next page
     * @return bool
     */
    public function hasNext();

    /**
     * Check to determine the availability of a previous page
     * @return bool
     */
    public function hasPrevious();

    /**
     * Fetch the next page
     * @return array
     */
    public function fetchNext();

    /**
     * Fetch the previous page
     * @return array
     */
    public function fetchPrevious();

    /**
     * Fetch the first page
     * @return array
     */
    public function fetchFirst();

    /**
     * Fetch the last page
     * @return array
     */
    public function fetchLast();
}
