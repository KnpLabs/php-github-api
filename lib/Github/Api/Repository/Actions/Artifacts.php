<?php

namespace Github\Api\Repository\Actions;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/actions/artifacts
 */
class Artifacts extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/actions/artifacts#list-artifacts-for-a-repository
     *
     * @param string $username
     * @param string $repository
     * @param array  $parameters
     *
     * @return array
     */
    public function all(string $username, string $repository, array $parameters = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/artifacts', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/actions/artifacts#list-workflow-run-artifacts
     *
     * @param string $username
     * @param string $repository
     * @param int    $runId
     *
     * @return array
     */
    public function runArtifacts(string $username, string $repository, int $runId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/runs/'.$runId.'/artifacts');
    }

    /**
     * @link https://docs.github.com/rest/actions/artifacts#get-an-artifact
     *
     * @param string $username
     * @param string $repository
     * @param int    $artifactId
     *
     * @return array
     */
    public function show(string $username, string $repository, int $artifactId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/artifacts/'.$artifactId);
    }

    /**
     * @link https://docs.github.com/rest/actions/artifacts#delete-an-artifact
     *
     * @param string $username
     * @param string $repository
     * @param int    $artifactId
     *
     * @return array
     */
    public function remove(string $username, string $repository, int $artifactId)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/artifacts/'.$artifactId);
    }

    /**
     * @link https://docs.github.com/rest/actions/artifacts#download-an-artifact
     *
     * @param string $username
     * @param string $repository
     * @param int    $artifactId
     * @param string $format
     *
     * @return array
     */
    public function download(string $username, string $repository, int $artifactId, string $format = 'zip')
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/actions/artifacts/'.$artifactId.'/'.$format);
    }
}
