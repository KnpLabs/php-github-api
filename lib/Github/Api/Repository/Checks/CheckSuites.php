<?php

namespace Github\Api\Repository\Checks;

use Github\Api\AbstractApi;

/**
 * @link https://docs.github.com/rest/checks/suites
 */
class CheckSuites extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/checks/suites#create-a-check-suite
     *
     * @return array
     */
    public function create(string $username, string $repository, array $params = [])
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-suites', $params);
    }

    /**
     * @link https://docs.github.com/rest/checks/suites#update-repository-preferences-for-check-suites
     *
     * @return array
     */
    public function updatePreferences(string $username, string $repository, array $params = [])
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-suites/preferences', $params);
    }

    /**
     * @link https://docs.github.com/rest/checks/suites#get-a-check-suite
     *
     * @return array
     */
    public function getCheckSuite(string $username, string $repository, int $checkSuiteId)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-suites/'.$checkSuiteId);
    }

    /**
     * @link https://docs.github.com/rest/checks/suites#rerequest-a-check-suite
     *
     * @return array
     */
    public function rerequest(string $username, string $repository, int $checkSuiteId)
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-suites/'.$checkSuiteId.'/rerequest');
    }

    /**
     * @link https://docs.github.com/rest/checks/suites#list-check-suites-for-a-git-reference
     *
     * @return array
     */
    public function allForReference(string $username, string $repository, string $ref, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($ref).'/check-suites', $params);
    }
}
