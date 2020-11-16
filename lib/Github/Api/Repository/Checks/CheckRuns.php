<?php

namespace Github\Api\Repository\Checks;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks
 */
class CheckRuns extends AbstractApi
{
    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#create-a-check-run
     *
     * @return array
     */
    public function create(string $username, string $repository, array $params = [])
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs', $params);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#get-a-check-run
     *
     * @return array
     */
    public function show(string $username, string $repository, int $checkRunId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.$checkRunId);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#update-a-check-run
     *
     * @return array
     */
    public function update(string $username, string $repository, int $checkRunId, array $params = [])
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.$checkRunId, $params);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#list-check-run-annotations
     *
     * @return array
     */
    public function annotations(string $username, string $repository, int $checkRunId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.$checkRunId.'/annotations');
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#list-check-runs-in-a-check-suite
     *
     * @return array
     */
    public function allForCheckSuite(string $username, string $repository, int $checkSuiteId, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-suites/'.$checkSuiteId.'/check-runs', $params);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/checks#list-check-runs-for-a-git-reference
     *
     * @return array
     */
    public function allForReference(string $username, string $repository, string $ref, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($ref).'/check-runs', $params);
    }
}
