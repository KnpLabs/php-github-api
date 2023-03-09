<?php

namespace Github\Api\Environment;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28
 */
class Secrets extends AbstractApi
{
    /**
     * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#list-environment-secrets
     *
     * @param int    $id
     * @param string $name
     *
     * @return array|string
     */
    public function all(int $id, string $name)
    {
        return $this->get('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/secrets');
    }

    /**
     * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#get-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     *
     * @return array|string
     */
    public function show(int $id, string $name, string $secretName)
    {
        return $this->get('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName));
    }

    /**
     * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#create-or-update-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     * @param array  $parameters
     *
     * @throws MissingArgumentException
     *
     * @return array|string
     */
    public function createOrUpdate(int $id, string $name, string $secretName, array $parameters = [])
    {
        if (!isset($parameters['encrypted_value'])) {
            throw new MissingArgumentException(['encrypted_value']);
        }

        if (!isset($parameters['key_id'])) {
            throw new MissingArgumentException(['key_id']);
        }

        return $this->put('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName), $parameters);
    }

    /**
     * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#delete-an-environment-secret
     *
     * @param int    $id
     * @param string $name
     * @param string $secretName
     *
     * @return array|string
     */
    public function remove(int $id, string $name, string $secretName)
    {
        return $this->delete('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/secrets/'.rawurlencode($secretName));
    }

    /**
     * @link https://docs.github.com/en/rest/actions/secrets?apiVersion=2022-11-28#get-an-environment-public-key
     *
     * @param int    $id
     * @param string $name
     *
     * @return array|string
     */
    public function publicKey(int $id, string $name)
    {
        return $this->get('/repositories/'.rawurlencode($id).'/environments/'.rawurlencode($name).'/secrets/public-key');
    }
}
