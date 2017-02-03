<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/repos/branches/#get-branch-protection
 * @author Brandon Bloodgood <bbloodgood@gmail.com>
 */
class Protection extends AbstractApi
{
    public function show($username, $repository, $branch)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches/'.rawurlencode($branch).'/protection');
    }

    public function update($username, $repository, $branch, array $params = array())
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches/'.rawurlencode($branch).'/protection', $params);
    }
}
