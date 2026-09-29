<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/repos/forks
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Forks extends AbstractApi
{
    /**
     * List forks of a repository.
     *
     * @link https://docs.github.com/rest/repos/forks#list-forks
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (e.g. sort)
     *
     * @return array
     */
    public function all($username, $repository, array $params = [])
    {
        if (isset($params['sort']) && !in_array($params['sort'], ['newest', 'oldest', 'watchers'])) {
            $params['sort'] = 'newest';
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', array_merge(['page' => 1], $params));
    }

    /**
     * Create a fork of a repository.
     *
     * @link https://docs.github.com/rest/repos/forks#create-a-fork
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (e.g. organization, name, default_branch_only)
     *
     * @return array
     */
    public function create($username, $repository, array $params = [])
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/forks', $params);
    }
}
