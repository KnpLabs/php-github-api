<?php

namespace Github\Api;

/**
 * @link   https://developer.github.com/v3/integrations/
 * @author Nils Adermann <naderman@naderman.de>
 */
class Integrations extends AbstractApi
{
    /**
     * Create an access token for an installation
     *
     * @param int $installationId An integration installation id
     * @param int $userId         An optional user id on behalf of whom the
     *                            token will be requested
     *
     * @return array token and token metadata
     */
    public function createInstallationToken($installationId, $userId = null)
    {
        $parameters = array();
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        return $this->post('/installations/'.rawurlencode($installationId).'/access_tokens', $parameters);
    }

    /**
     * Find all installations for the authenticated integration.
     *
     * @link https://developer.github.com/v3/integrations/#find-installations
     *
     * @return array
     */
    public function findInstallations()
    {
        return $this->get('/integration/installations');
    }

    /**
     * List repositories that are accessible to the authenticated installation.
     *
     * @link https://developer.github.com/v3/integrations/installations/#list-repositories
     *
     * @param int $userId
     *
     * @return array
     */
    public function listRepositories($userId = null)
    {
        $parameters = array();
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        return $this->get('/installation/repositories', $parameters);
    }

    /**
     * Add a single repository to an installation.
     *
     * @link https://developer.github.com/v3/integrations/installations/#add-repository-to-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function addRepository($installationId, $repositoryId)
    {
        return $this->put('/installations/'.rawurlencode($installationId).'/repositories/'.rawurlencode($repositoryId));
    }

    /**
     * Remove a single repository from an installation.
     *
     * @link https://developer.github.com/v3/integrations/installations/#remove-repository-from-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function removeRepository($installationId, $repositoryId)
    {
        return $this->delete('/installations/'.rawurlencode($installationId).'/repositories/'.rawurlencode($repositoryId));
    }
}
