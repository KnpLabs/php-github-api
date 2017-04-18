<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link   https://developer.github.com/v3/repos/branches/
 * @author Brandon Bloodgood <bbloodgood@gmail.com>
 */
class Protection extends AbstractApi
{
    use AcceptHeaderTrait;

    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.loki-preview+json';

        return $this;
    }

    /**
     * Retrieves configured protection for the provided branch
     *
     * @link https://developer.github.com/v3/repos/branches/#get-branch-protection
     *
     * @param  string $username   The user who owns the repository
     * @param  string $repository The name of the repo
     * @param  string $branch     The name of the branch
     *
     * @return array              The branch protection information
     */
    public function show($username, $repository, $branch)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches/'.rawurlencode($branch).'/protection');
    }

    /**
     * Updates the repo's branch protection
     *
     * @link https://developer.github.com/v3/repos/branches/#update-branch-protection
     *
     * @param  string $username   The user who owns the repository
     * @param  string $repository The name of the repo
     * @param  string $branch     The name of the branch
     * @param  array  $params     The branch protection information
     *
     * @return array              The updated branch protection information
     */
    public function update($username, $repository, $branch, array $params = array())
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches/'.rawurlencode($branch).'/protection', $params);
    }
}
