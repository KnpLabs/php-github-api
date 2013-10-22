<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/releases/
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Assets extends AbstractApi
{
    /**
     * @deprecated Will be removed as soon as gh releases api gets stable
     */
    public function configure()
    {
        $this->client->setHeaders(array(
            'Accept: application/vnd.github.manifold-preview'
        ));
    }

    /**
     * Get all release's assets in selected repository
     * GET /repos/:owner/:repo/releases/:id/assets
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the release
     *
     * @return array
     */
    public function all($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id).'/assets');
    }

    /**
     * Get an asset in selected repository's release
     * GET /repos/:owner/:repo/releases/assets/:id
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the asset
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id));
    }

    /**
     * Edit an asset in selected repository's release
     * PATCH /repos/:owner/:repo/releases/assets/:id
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the asset
     * @param  array   $params           request parameters
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function edit($username, $repository, $id, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }

        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id), $params);
    }

    /**
     * Delete an asset in selected repository's release
     * DELETE /repos/:owner/:repo/releases/assets/:id
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the asset
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id));
    }
}
