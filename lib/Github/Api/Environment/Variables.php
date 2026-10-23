<?php

namespace Github\Api\Environment;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/actions/variables
 */
class Variables extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/actions/variables#list-environment-variables
     *
     * @param int    $id
     * @param string $name
     *
     * @return array|string
     */
    public function all(int $id, string $name)
    {
        return $this->get('/repositories/'.$id.'/environments/'.rawurlencode($name).'/variables');
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#get-an-environment-variable
     *
     * @param int    $id
     * @param string $name
     * @param string $variableName
     *
     * @return array|string
     */
    public function show(int $id, string $name, string $variableName)
    {
        return $this->get('/repositories/'.$id.'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName));
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#create-an-environment-variable
     *
     * @param int    $id
     * @param string $name
     * @param array  $parameters
     *
     * @return array|string
     */
    public function create(int $id, string $name, array $parameters)
    {
        return $this->post('/repositories/'.$id.'/environments/'.rawurlencode($name).'/variables', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#update-an-environment-variable
     *
     * @param int    $id
     * @param string $name
     * @param string $variableName
     * @param array  $parameters
     *
     * @return array|string
     */
    public function update(int $id, string $name, string $variableName, array $parameters)
    {
        return $this->patch('/repositories/'.$id.'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName), $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/variables#delete-an-environment-variable
     *
     * @param int    $id
     * @param string $name
     * @param string $variableName
     *
     * @return array|string
     */
    public function remove(int $id, string $name, string $variableName)
    {
        return $this->delete('/repositories/'.$id.'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName));
    }
}
