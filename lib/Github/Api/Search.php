<?php

namespace Github\Api;

/**
 * Implement the Search API.
 *
 * @link   https://developer.github.com/v3/search/
 *
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
     * @param string $q      the filter
     * @param string $sort   the sort field
     * @param string $order  asc/desc
     * @param array  $params
     *
     * @return array list of repositories found
     */
    public function repositories($q, $sort = 'updated', $order = 'desc', array $params = [])
    {
        return $this->get('/search/repositories', array_merge(['q' => $q, 'sort' => $sort, 'order' => $order], $params));
    }

    /**
     * Search issues by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-issues
     *
     * @param string $q      the filter
     * @param string $sort   the sort field
     * @param string $order  asc/desc
     * @param array  $params
     *
     * @return array list of issues found
     */
    public function issues($q, $sort = 'updated', $order = 'desc', array $params = [])
    {
        return $this->get('/search/issues', array_merge(['q' => $q, 'sort' => $sort, 'order' => $order], $params));
    }

    /**
     * Search code by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-code
     *
     * @param string $q      the filter
     * @param string $sort   the sort field
     * @param string $order  asc/desc
     * @param array  $params
     *
     * @return array list of code found
     */
    public function code($q, $sort = 'updated', $order = 'desc', array $params = [])
    {
        return $this->get('/search/code', array_merge(['q' => $q, 'sort' => $sort, 'order' => $order], $params));
    }

    /**
     * Search users by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-users
     *
     * @param string $q      the filter
     * @param string $sort   the sort field
     * @param string $order  asc/desc
     * @param array  $params
     *
     * @return array list of users found
     */
    public function users($q, $sort = 'updated', $order = 'desc', array $params = [])
    {
        return $this->get('/search/users', array_merge(['q' => $q, 'sort' => $sort, 'order' => $order], $params));
    }

    /**
     * Search commits by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-commits
     *
     * @param string $q      the filter
     * @param string $sort   the sort field
     * @param string $order  sort order. asc/desc
     * @param array  $params
     *
     * @return array
     */
    public function commits($q, $sort = null, $order = 'desc', array $params = [])
    {
        // This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.cloak-preview';

        return $this->get('/search/commits', array_merge(['q' => $q, 'sort' => $sort, 'order' => $order], $params));
    }

    /**
     * Search topics by filter (q).
     *
     * @link https://developer.github.com/v3/search/#search-topics
     *
     * @param string $q      the filter
     * @param array  $params
     *
     * @return array
     */
    public function topics($q, array $params = [])
    {
        // This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.mercy-preview+json';

        return $this->get('/search/topics', array_merge(['q' => $q], $params));
    }
}
