<?php

namespace Github\Api\Environment;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28
 */
class Variables extends AbstractApi
{
    /**
     * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#list-environment-variables
     *
     * @param int $id
     * @param string $name
     *
     * @return array|string
     */
    public function all(int $id, string $name)
    {
        return $this->get('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/variables');
    }

    /**
     * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#get-an-environment-variable
     *
     * @param int $id
     * @param string $name
     * @param string $variableName
     *
     * @return array|string
     */
    public function show(int $id, string $name, string $variableName)
    {
        return $this->get('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName));
    }

    /**
     * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#create-an-environment-variable
     *
     * @param int $id
     * @param string $name
     * @param array  $parameters
     *
     * @throws MissingArgumentException
     *
     * @return array|string
     */
    public function create(int $id, string $name, array $parameters)
    {
        if (!isset($parameters['name'])) {
            throw new MissingArgumentException(['name']);
        }

        if (!isset($parameters['value'])) {
            throw new MissingArgumentException(['value']);
        }

        return $this->post('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/variables', $parameters);
    }

    /**
     * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#update-an-environment-variable
     *
     * @param int $id
     * @param string $name
     * @param string $variableName
     * @param array  $parameters
     *
     * @throws MissingArgumentException
     *
     * @return array|string
     */
    public function update(int $id, string $name, string $variableName, array $parameters)
    {
        return $this->patch('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName), $parameters);
    }

    /**
     * @link https://docs.github.com/en/rest/actions/variables?apiVersion=2022-11-28#delete-an-environment-variable
     *
     * @param int $id
     * @param string $name
     * @param string $variableName
     *
     * @return array|string
     */
    public function remove(int $id, string $name, string $variableName)
    {
        return $this->delete('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/variables/'.rawurlencode($variableName));
    }
}
