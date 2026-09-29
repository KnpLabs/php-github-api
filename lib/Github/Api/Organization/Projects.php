<?php

namespace Github\Api\Organization;

use Github\Api\Project\AbstractProjectApi;
use Github\Exception\MissingArgumentException;

/**
 * @link https://docs.github.com/enterprise-server@3.11/rest/projects/projects
 */
class Projects extends AbstractProjectApi
{
    /**
     * List the projects (classic) in an organization.
     *
     * @link https://docs.github.com/enterprise-server@3.11/rest/projects/projects#list-organization-projects
     *
     * @param string $organization the organization
     * @param array  $params       a list of extra parameters
     *
     * @return array
     */
    public function all($organization, array $params = [])
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/projects', array_merge(['page' => 1], $params));
    }

    /**
     * Create an organization project (classic).
     *
     * @link https://docs.github.com/enterprise-server@3.11/rest/projects/projects#create-an-organization-project
     *
     * @param string $organization the organization
     * @param array  $params       the parameters (name is required)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($organization, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException(['name']);
        }

        return $this->post('/orgs/'.rawurlencode($organization).'/projects', $params);
    }
}
