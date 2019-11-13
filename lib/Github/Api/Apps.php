<?php

namespace Github\Api;

/**
 * @link   https://developer.github.com/v3/apps/
 *
 * @author Nils Adermann <naderman@naderman.de>
 */
class Apps extends AbstractApi
{
    use AcceptHeaderTrait;

    private function configurePreviewHeader()
    {
        $this->acceptHeaderValue = 'application/vnd.github.machine-man-preview+json';
    }

    /**
     * Create an access token for an installation.
     *
     * @param int $installationId An integration installation id
     * @param int $userId         An optional user id on behalf of whom the
     *                            token will be requested
     *
     * @link https://developer.github.com/v3/apps/#create-a-new-installation-token
     *
     * @return array token and token metadata
     */
    public function createInstallationToken($installationId, $userId = null)
    {
        $parameters = [];
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        $this->configurePreviewHeader();

        return $this->post('/app/installations/'.rawurlencode($installationId).'/access_tokens', $parameters);
    }

    /**
     * Find all installations for the authenticated application.
     *
     * @link https://developer.github.com/v3/apps/#find-installations
     *
     * @return array
     */
    public function findInstallations()
    {
        $this->configurePreviewHeader();

        return $this->get('/app/installations');
    }

    /**
     * Get an installation of the application
     *
     * @link https://developer.github.com/v3/apps/#get-an-installation
     *
     * @param $installation_id An integration installation id
     * @return array
     */
    public function getInstallation($installation_id)
    {
        return $this->get('/app/installations/'.rawurldecode($installation_id));
    }

    /**
     * Delete an installation of the application
     *
     * @link https://developer.github.com/v3/apps/#delete-an-installation
     *
     * @param $installation_id An integration installation id
     */
    public function removeInstallation($installation_id)
    {
        $this->delete('/app/installations/'.rawurldecode($installation_id));
    }

    /**
     * List repositories that are accessible to the authenticated installation.
     *
     * @link https://developer.github.com/v3/apps/installations/#list-repositories
     *
     * @param int $userId
     *
     * @return array
     */
    public function listRepositories($userId = null)
    {
        $parameters = [];
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        $this->configurePreviewHeader();

        return $this->get('/installation/repositories', $parameters);
    }

    /**
     * Add a single repository to an installation.
     *
     * @link https://developer.github.com/v3/apps/installations/#add-repository-to-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function addRepository($installationId, $repositoryId)
    {
        $this->configurePreviewHeader();

        return $this->put('/installations/'.rawurlencode($installationId).'/repositories/'.rawurlencode($repositoryId));
    }

    /**
     * Remove a single repository from an installation.
     *
     * @link https://developer.github.com/v3/apps/installations/#remove-repository-from-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function removeRepository($installationId, $repositoryId)
    {
        $this->configurePreviewHeader();

        return $this->delete('/installations/'.rawurlencode($installationId).'/repositories/'.rawurlencode($repositoryId));
    }
}
