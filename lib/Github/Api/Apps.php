<?php declare(strict_types=1);

namespace Github\Api;

/**
 * @link   https://developer.github.com/v3/apps/
 * @author Nils Adermann <naderman@naderman.de>
 */
class Apps extends AbstractApi
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
    public function createInstallationToken(int $installationId, int $userId = null): array
    {
        $parameters = array();
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        return $this->post('/installations/'.rawurlencode($installationId).'/access_tokens', $parameters);
    }

    /**
     * Find all installations for the authenticated application.
     *
     * @link https://developer.github.com/v3/apps/#find-installations
     *
     * @return array
     */
    public function findInstallations(): array
    {
        return $this->get('/app/installations');
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
    public function listRepositories(int $userId = null): array
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
     * @link https://developer.github.com/v3/apps/installations/#add-repository-to-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function addRepository(int $installationId, int $repositoryId): array
    {
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
    public function removeRepository(int $installationId, int $repositoryId): array
    {
        return $this->delete('/installations/'.rawurlencode($installationId).'/repositories/'.rawurlencode($repositoryId));
    }
}
