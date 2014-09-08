<?php

namespace Github\Api;

use Github\Api\Issue\Comments;
use Github\Api\Issue\Events;
use Github\Api\Issue\Labels;
use Github\Api\Issue\Milestones;
use Github\Exception\MissingArgumentException;

/**
 * Implement the Search API.
 *
 * @link   https://developer.github.com/v3/search/
 * @author Greg Payne <greg.payne@gmail.com>
 */
class Search extends AbstractApi
{
    /**
     * Search by filter (q)
     * @link http://developer.github.com/v3/search/
     *
     * @param string $type       the search type
     * @param string $q          the filter
     * @param string $sort       the sort field
     * @param string $order      asc/desc
     *
     * @return array list of issues found
     */
    public function find($type = 'issues', $q = '', $sort = 'updated', $order = 'desc')
    {
        if (!in_array($type, array('issues', 'repositories', 'code', 'users'))) {
            $type = 'issues';
        }
        return $this->get("/search/$type", array('q' => $q, 'sort' => $sort, 'order' => $order));
    }

}
