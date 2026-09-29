<?php

namespace Github\Api\Environment;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/actions/secrets
 */
class Secrets extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/actions/secrets#list-environment-secrets
     *
     * @param int    $id
     * @param string $name
     *
     * @return array|string
     */
    public function all(int $id, string $name)
    {
        return $this->get('/repositories/'.$id.'/environments/'.rawurlencode($name).'/secrets');
    }

    /**
     * @link https://docs.github.com/rest/actions/secrets#get-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     *
     * @return array|string
     */
    public function show(int $id, string $name, string $secretName)
    {
        return $this->get('/repositories/'.$id.'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName));
    }

    /**
     * @link https://docs.github.com/rest/actions/secrets#create-or-update-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     * @param array  $parameters
     *
     * @return array|string
     */
    public function createOrUpdate(int $id, string $name, string $secretName, array $parameters = [])
    {
        return $this->put('/repositories/'.$id.'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName), $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/secrets#delete-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     *
     * @return array|string
     */
    public function remove(int $id, string $name, string $secretName)
    {
        return $this->delete('/repositories/'.$id.'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName));
    }

    /**
     * @link https://docs.github.com/rest/actions/secrets#get-an-environment-public-key
     *
     * @param int    $id
     * @param string $name
     *
     * @return array|string
     */
    public function publicKey(int $id, string $name)
    {
        return $this->get('/repositories/'.$id.'/environments/'.rawurlencode($name).'/secrets/public-key');
    }
}
