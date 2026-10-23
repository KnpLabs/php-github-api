<?php

namespace Github\Api\Project;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * Base class for the "Projects (classic)" boards API.
 *
 * @deprecated GitHub Projects (classic) was sunset on 2024-08-23 and this REST API is no longer part of the
 *             current documentation on docs.github.com (superseded by the Projects v2 GraphQL/REST API).
 */
abstract class AbstractProjectApi extends AbstractApi
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
     * Get a classic project by id.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the project
     * @param array      $params the parameters
     *
     * @return array
     */
    public function show($id, array $params = [])
    {
        return $this->get('/projects/'.rawurlencode($id), array_merge(['page' => 1], $params));
    }

    /**
     * Update a classic project.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the project to update
     * @param array      $params the parameters to update (name, body, state, organization_permission, private)
     *
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->patch('/projects/'.rawurlencode($id), $params);
    }

    /**
     * Delete a classic project.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id the id of the project
     *
     * @return array
     */
    public function deleteProject($id)
    {
        return $this->delete('/projects/'.rawurlencode($id));
    }

    /**
     * @deprecated GitHub Projects (classic) was sunset by GitHub.
     *
     * @return Columns
     */
    public function columns()
    {
        return new Columns($this->getClient());
    }
}
