<?php

namespace Github\Api\Repository;

use Github\Api\Project\AbstractProjectApi;
use Github\Exception\MissingArgumentException;

/**
 * Repository-scoped "Projects (classic)" boards.
 *
 * @deprecated GitHub Projects (classic) was sunset on 2024-08-23 and this REST API is no longer part of the
 *             current documentation on docs.github.com (superseded by the Projects v2 GraphQL/REST API).
 */
class Projects extends AbstractProjectApi
{
    /**
     * List the classic projects of a repository.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (state)
     *
     * @return array
     */
    public function all($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', array_merge(['page' => 1], $params));
    }

    /**
     * Create a classic project for a repository.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (name, body)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(['name']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/projects', $params);
    }
}
