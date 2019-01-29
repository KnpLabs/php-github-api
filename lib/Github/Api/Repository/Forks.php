<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Model\Fork;
use function Makasim\Values\set_values;

/**
 * @link   http://developer.github.com/v3/repos/forks/
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Forks extends AbstractApi
{
    /**
     * @return Fork[]
     */
    public function all($username, $repository, array $params = [])
    {
        if (isset($params['sort']) && !in_array($params['sort'], ['newest', 'oldest', 'watchers'])) {
            $params['sort'] = 'newest';
        }

        $rawForks = $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', array_merge(['page' => 1], $params));

        $forks = [];
        foreach ($rawForks as $rawFork) {
            $fork = new Fork();
            set_values($fork, $rawFork);

            $forks[] = $fork;
        }

        return $forks;
    }

    /**
     * @return Fork
     */
    public function create($username, $repository, array $params = [])
    {
        $rawFork = $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', $params);

        $fork = new Fork();
        set_values($fork, $rawFork);

        return $fork;
    }
}
