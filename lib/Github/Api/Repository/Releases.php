<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/releases/
 * @author Matthew Simo <matthew.a.simo@gmail.com>
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Releases extends AbstractApi
{
    /**
     * List releases in selected repository
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases');
    }

    /**
     * Get a release in selected repository
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the release
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id));
    }

    /**
     * Create new release in selected repository
     *
     * @param  string  $username
     * @param  string  $repository
     * @param  array   $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['tag_name'])) {
            throw new MissingArgumentException('tag_name');
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases', $params);
    }

    /**
     * Edit release in selected repository
     *
     * @param  string  $username
     * @param  string  $repository
     * @param  integer $id
     * @param  array   $params
     *
     * @return array
     */
    public function edit($username, $repository, $id, array $params)
    {
        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id), $params);
    }

    /**
     * Delete a release in selected repository (Not thoroughly tested!)
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the release
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id));
    }

    /**
     * @return Assets
     */
    public function assets()
    {
        return new Assets($this->client);
    }
}
