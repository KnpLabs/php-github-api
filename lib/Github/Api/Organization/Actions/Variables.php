<?php

namespace Github\Api\Organization\Actions;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/actions/variables
 */
class Variables extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/actions/variables#list-organization-variables
     *
     * @param string $organization
     *
     * @return array|string
     */
    public function all(string $organization)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/actions/variables');
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#get-an-organization-variable
     *
     * @param string $organization
     * @param string $variableName
     *
     * @return array|string
     */
    public function show(string $organization, string $variableName)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName));
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#create-an-organization-variable
     *
     * @param string $organization
     * @param array  $parameters
     *
     * @return array|string
     */
    public function create(string $organization, array $parameters)
    {
        return $this->post('/orgs/'.rawurlencode($organization).'/actions/variables', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#update-an-organization-variable
     *
     * @param string $organization
     * @param string $variableName
     * @param array  $parameters
     *
     * @return array|string
     */
    public function update(string $organization, string $variableName, array $parameters = [])
    {
        return $this->patch('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName), $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#delete-an-organization-variable
     *
     * @param string $organization
     * @param string $variableName
     *
     * @return array|string
     */
    public function remove(string $organization, string $variableName)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName));
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#list-selected-repositories-for-an-organization-variable
     *
     * @param string $organization
     * @param string $variableName
     *
     * @return array|string
     */
    public function selectedRepositories(string $organization, string $variableName)
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName).'/repositories');
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#set-selected-repositories-for-an-organization-variable
     *
     * @param string $organization
     * @param string $variableName
     * @param array  $parameters
     *
     * @return array|string
     */
    public function setSelectedRepositories(string $organization, string $variableName, array $parameters = [])
    {
        return $this->put('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName).'/repositories', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#add-selected-repository-to-an-organization-variable
     *
     * @param string $organization
     * @param int    $repositoryId
     * @param string $variableName
     *
     * @return array|string
     */
    public function addRepository(string $organization, int $repositoryId, string $variableName)
    {
        return $this->put('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName).'/repositories/'.$repositoryId);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#remove-selected-repository-from-an-organization-variable
     *
     * @param string $organization
     * @param int    $repositoryId
     * @param string $variableName
     *
     * @return array|string
     */
    public function removeRepository(string $organization, int $repositoryId, string $variableName)
    {
        return $this->delete('/orgs/'.rawurlencode($organization).'/actions/variables/'.rawurlencode($variableName).'/repositories/'.$repositoryId);
    }
}
