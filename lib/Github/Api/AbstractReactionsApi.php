<?php

namespace Github\Api;

use Github\Exception\MissingArgumentException;

abstract class AbstractReactionsApi extends AbstractApi
{
    /**
     * List reactions for a resource.
     *
     * @param string $username
     * @param string $repository
     * @param string $id
     * @param array  $params
     *
     * @return array
     */
    public function all($username, $repository, $id, array $params = [])
    {
        return $this->get($this->getReactionsPath($username, $repository, $id), $params);
    }

    /**
     * Create a reaction for a resource.
     *
     * @param string $username
     * @param string $repository
     * @param string $id
     * @param array  $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, $id, array $params)
    {
        if (!isset($params['content'])) {
            throw new MissingArgumentException('content');
        }

        return $this->post($this->getReactionsPath($username, $repository, $id), $params);
    }

    /**
     * Delete a reaction from a resource.
     *
     * @param string $username
     * @param string $repository
     * @param string $id
     * @param string $reaction
     *
     * @return array|string
     */
    public function remove($username, $repository, $id, $reaction)
    {
        return $this->delete($this->getReactionsPath($username, $repository, $id).'/'.rawurlencode($reaction));
    }

    /**
     * @param string $username
     * @param string $repository
     * @param string $id
     *
     * @return string
     */
    abstract protected function getReactionsPath($username, $repository, $id);
}
