<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/forks/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Forks extends AbstractApi
{
    public function all($username, $repository, array $params = array())
    {
        if (isset($params['sort']) && !in_array($params['sort'], array('newest', 'oldest', 'watchers'))) {
            $params['sort'] = 'newest';
        }

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', array_merge(array('page' => 1), $params));
    }

    public function create($username, $repository, array $params = array())
    {
        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', $params);
    }
}
