<?php

namespace Github\Api\Repository\Actions;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/actions/variables
 */
class Variables extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/actions/variables#list-repository-variables
     *
     * @param string $username
     * @param string $repository
     *
     * @return array|string
     */
    public function all(string $username, string $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/variables');
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#get-a-repository-variable
     *
     * @param string $username
     * @param string $repository
     * @param string $variableName
     *
     * @return array|string
     */
    public function show(string $username, string $repository, string $variableName)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/variables/'.rawurlencode($variableName));
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#create-a-repository-variable
     *
     * @param string $username
     * @param string $repository
     * @param array  $parameters
     *
     * @return array|string
     */
    public function create(string $username, string $repository, array $parameters = [])
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/variables', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#update-a-repository-variable
     *
     * @param string $username
     * @param string $repository
     * @param string $variableName
     * @param array  $parameters
     *
     * @return array|string
     */
    public function update(string $username, string $repository, string $variableName, array $parameters = [])
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/variables/'.rawurlencode($variableName), $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#delete-a-repository-variable
     *
     * @param string $username
     * @param string $repository
     * @param string $variableName
     *
     * @return array|string
     */
    public function remove(string $username, string $repository, string $variableName)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/variables/'.rawurlencode($variableName));
    }
}
