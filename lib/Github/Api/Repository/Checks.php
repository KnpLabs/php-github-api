<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://developer.github.com/v3/checks/
 *
 * @author Zack Galbreath <zack.galbreath@kitware.com>
 */
class Checks extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * @link https://developer.github.com/v3/checks/runs/#create-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params = [])
    {
        if (!isset($params['name'], $params['head_sha'])) {
            throw new MissingArgumentException(['name', 'head_sha']);
        }

        // This api is in preview mode, so set the correct accept-header.
        $this->acceptHeaderValue = 'application/vnd.github.antiope-preview+json';

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs', $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#update-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     * @param array  $params
     *
     * @return array
     */
    public function update($username, $repository, $checkRunId, array $params = [])
    {
        // This api is in preview mode, so set the correct accept-header.
        $this->acceptHeaderValue = 'application/vnd.github.antiope-preview+json';

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId), $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#list-check-runs-for-a-git-reference
     *
     * @param string $username
     * @param string $repository
     * @param string $ref
     * @param array  $params
     *
     * @return array
     */
    public function all($username, $repository, $ref, $params = [])
    {
        // This api is in preview mode, so set the correct accept-header.
        $this->acceptHeaderValue = 'application/vnd.github.antiope-preview+json';

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($ref).'/check-runs', $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#get-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     *
     * @return array
     */
    public function show($username, $repository, $checkRunId)
    {
        // This api is in preview mode, so set the correct accept-header.
        $this->acceptHeaderValue = 'application/vnd.github.antiope-preview+json';

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId));
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#list-check-run-annotations
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     *
     * @return array
     */
    public function annotations($username, $repository, $checkRunId)
    {
        // This api is in preview mode, so set the correct accept-header.
        $this->acceptHeaderValue = 'application/vnd.github.antiope-preview+json';

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId).'/annotations');
    }
}
