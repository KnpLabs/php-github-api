<?php

namespace Github\Api\Project;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * "Project (classic)" columns API.
 *
 * @deprecated GitHub Projects (classic) was sunset on 2024-08-23 and this REST API is no longer part of the
 *             current documentation on docs.github.com (superseded by the Projects v2 GraphQL/REST API).
 */
class Columns extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header for Early Access to the projects (classic) api.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @return $this
     */
    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.inertia-preview+json';

        return $this;
    }

    /**
     * List the columns of a classic project.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $projectId the id of the project
     * @param array      $params    the parameters
     *
     * @return array
     */
    public function all($projectId, array $params = [])
    {
        return $this->get('/projects/'.rawurlencode($projectId).'/columns', array_merge(['page' => 1], $params));
    }

    /**
     * Get a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id the id of the column
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get('/projects/columns/'.rawurlencode($id));
    }

    /**
     * Create a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $projectId the id of the project
     * @param array      $params    the parameters (name)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($projectId, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(['name']);
        }

        return $this->post('/projects/'.rawurlencode($projectId).'/columns', $params);
    }

    /**
     * Update a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the column to update
     * @param array      $params the parameters to update (name)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function update($id, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(['name']);
        }

        return $this->patch('/projects/columns/'.rawurlencode($id), $params);
    }

    /**
     * Delete a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id the id of the column
     *
     * @return array
     */
    public function deleteColumn($id)
    {
        return $this->delete('/projects/columns/'.rawurlencode($id));
    }

    /**
     * Move a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the column to move
     * @param array      $params the parameters (position)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function move($id, array $params)
    {
        if (!isset($params['position'])) {
            throw new MissingArgumentException(['position']);
        }

        return $this->post('/projects/columns/'.rawurlencode($id).'/moves', $params);
    }

    /**
     * @deprecated GitHub Projects (classic) was sunset by GitHub.
     *
     * @return Cards
     */
    public function cards()
    {
        return new Cards($this->getClient());
    }
}
