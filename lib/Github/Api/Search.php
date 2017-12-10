<?php

namespace Github\Api;

/**
 * Implement the Search API.
 *
 * @link   https://developer.github.com/v3/search/
 * @author Greg Payne <greg.payne@gmail.com>
 */
class Search extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Search repositories by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-repositories
     *
     * @param string $q     the filter
     * @param string $sort  the sort field
     * @param string $order asc/desc
     *
     * @return array list of repositories found
     */
    public function repositories($q, $sort = 'updated', $order = 'desc')
    {
        return $this->get('/search/repositories', array('q' => $q, 'sort' => $sort, 'order' => $order));
    }

    /**
     * Search issues by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-issues
     *
     * @param string $q     the filter
     * @param string $sort  the sort field
     * @param string $order asc/desc
     *
     * @return array list of issues found
     */
    public function issues($q, $sort = 'updated', $order = 'desc')
    {
        return $this->get('/search/issues', array('q' => $q, 'sort' => $sort, 'order' => $order));
    }

    /**
     * Search code by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-code
     *
     * @param string $q     the filter
     * @param string $sort  the sort field
     * @param string $order asc/desc
     *
     * @return array list of code found
     */
    public function code($q, $sort = 'updated', $order = 'desc')
    {
        return $this->get('/search/code', array('q' => $q, 'sort' => $sort, 'order' => $order));
    }

    /**
     * Search users by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-users
     *
     * @param string $q     the filter
     * @param string $sort  the sort field
     * @param string $order asc/desc
     *
     * @return array list of users found
     */
    public function users($q, $sort = 'updated', $order = 'desc')
    {
        return $this->get('/search/users', array('q' => $q, 'sort' => $sort, 'order' => $order));
    }

    /**
     * Search commits by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-commits
     *
     * @param string $q     the filter
     * @param string $sort  the sort field
     * @param string $order sort order. asc/desc
     *
     * @return array
     */
    public function commits($q, $sort = null, $order = 'desc')
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.cloak-preview';

        return $this->get('/search/commits', array('q' => $q, 'sort' => $sort, 'order' => $order));
    }
}
