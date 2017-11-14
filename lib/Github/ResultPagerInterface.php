<?php declare(strict_types=1);

namespace Github;

use Github\Api\ApiInterface;

/**
 * Pager interface.
 *
 * @author Ramon de la Fuente <ramon@future500.nl>
 * @author Mitchel Verschoof <mitchel@future500.nl>
 */
interface ResultPagerInterface
{
    /**
     * @return null|array pagination result of last request
     */
    public function getPagination();

    /**
     * Fetch a single result (page) from an api call.
     *
     * @param ApiInterface $api        the Api instance
     * @param string       $method     the method name to call on the Api instance
     * @param array        $parameters the method parameters in an array
     *
     * @return array|string returns the result of the Api::$method() call
     */
    public function fetch(ApiInterface $api, string $method, array $parameters = array());

    /**
     * Fetch all results (pages) from an api call.
     *
     * Use with care - there is no maximum.
     *
     * @param ApiInterface $api        the Api instance
     * @param string       $method     the method name to call on the Api instance
     * @param array        $parameters the method parameters in an array
     *
     * @return array returns a merge of the results of the Api::$method() call
     */
    public function fetchAll(ApiInterface $api, string $method, array $parameters = array()): array;

    /**
     * Method that performs the actual work to refresh the pagination property.
     */
    public function postFetch();

    /**
     * Check to determine the availability of a next page.
     *
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * Check to determine the availability of a previous page.
     *
     * @return bool
     */
    public function hasPrevious(): bool;

    /**
     * Fetch the next page.
     *
     * @return array
     */
    public function fetchNext(): array;

    /**
     * Fetch the previous page.
     *
     * @return array
     */
    public function fetchPrevious(): array;

    /**
     * Fetch the first page.
     *
     * @return array
     */
    public function fetchFirst(): array;

    /**
     * Fetch the last page.
     *
     * @return array
     */
    public function fetchLast(): array;
}
