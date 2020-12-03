<?php

namespace Github\Api\Repository\Actions;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/actions#workflows
 */
class Workflows extends AbstractApi
{
    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/actions#list-repository-workflows
     *
     * @param string $username
     * @param string $repository
     * @param array  $parameters
     *
     * @return array
     */
    public function all(string $username, string $repository, array $parameters = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/workflows', $parameters);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/actions#get-a-workflow
     *
     * @param string $username
     * @param string $repository
     * @param int    $workflowId
     *
     * @return array
     */
    public function show(string $username, string $repository, int $workflowId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/workflows/'.$workflowId);
    }

    /**
     * @link https://docs.github.com/en/free-pro-team@latest/rest/reference/actions#get-workflow-usage
     *
     * @param string $username
     * @param string $repository
     * @param int    $workflowId
     *
     * @return array|string
     */
    public function usage(string $username, string $repository, int $workflowId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/workflows/'.$workflowId.'/timing');
    }
}
