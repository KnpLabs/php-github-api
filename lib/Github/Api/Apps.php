<?php

namespace Github\Api;

use Github\Api\App\Hook;

/**
 * @link   https://docs.github.com/rest/apps/apps
 *
 * @author Nils Adermann <naderman@naderman.de>
 */
class Apps extends AbstractApi
{
    /**
     * Create an access token for an installation.
     *
     * @param int $installationId An integration installation id
     * @param int $userId         An optional user id on behalf of whom the
     *                            token will be requested
     *
     * @link https://docs.github.com/rest/apps/apps#create-an-installation-access-token-for-an-app
     *
     * @return array token and token metadata
     */
    public function createInstallationToken($installationId, $userId = null)
    {
        $parameters = [];
        if ($userId) {
            $parameters['user_id'] = $userId;
        }

        return $this->post('/app/installations/'.$installationId.'/access_tokens', $parameters);
    }

    /**
     * Find all installations for the authenticated application.
     *
     * @link https://docs.github.com/rest/apps/apps#list-installations-for-the-authenticated-app
     *
     * @return array
     */
    public function findInstallations()
    {
        return $this->get('/app/installations');
    }

    /**
     * Get an installation of the application.
     *
     * @link https://docs.github.com/rest/apps/apps#get-an-installation-for-the-authenticated-app
     *
     * @param int $installationId An integration installation id
     *
     * @return array
     */
    public function getInstallation($installationId)
    {
        return $this->get('/app/installations/'.$installationId);
    }

    /**
     * Get an installation of the application for an organization.
     *
     * @link https://docs.github.com/rest/apps/apps#get-an-organization-installation-for-the-authenticated-app
     *
     * @param string $org An organization
     *
     * @return array
     */
    public function getInstallationForOrganization($org)
    {
        return $this->get('/orgs/'.rawurldecode($org).'/installation');
    }

    /**
     * Get an installation of the application for a repository.
     *
     * @link https://docs.github.com/rest/apps/apps#get-a-repository-installation-for-the-authenticated-app
     *
     * @param string $owner the owner of a repository
     * @param string $repo  the name of the repository
     *
     * @return array
     */
    public function getInstallationForRepo($owner, $repo)
    {
        return $this->get('/repos/'.rawurldecode($owner).'/'.rawurldecode($repo).'/installation');
    }

    /**
     * Get an installation of the application for a user.
     *
     * @link https://docs.github.com/rest/apps/apps#get-a-user-installation-for-the-authenticated-app
     *
     * @param string $username
     *
     * @return array
     */
    public function getInstallationForUser($username)
    {
        return $this->get('/users/'.rawurldecode($username).'/installation');
    }

    /**
     * Delete an installation of the application.
     *
     * @link https://docs.github.com/rest/apps/apps#delete-an-installation-for-the-authenticated-app
     *
     * @param int $installationId An integration installation id
     */
    public function removeInstallation($installationId)
    {
        $this->delete('/app/installations/'.$installationId);
    }

    /**
     * List repositories that are accessible to the authenticated installation.
     *
     * @link https://docs.github.com/rest/apps/installations#list-repositories-accessible-to-the-app-installation
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

        return $this->get('/installation/repositories', $parameters);
    }

    /**
     * Add a single repository to an installation.
     *
     * @link https://docs.github.com/rest/apps/installations#add-a-repository-to-an-app-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function addRepository($installationId, $repositoryId)
    {
        return $this->put('/installations/'.$installationId.'/repositories/'.$repositoryId);
    }

    /**
     * Remove a single repository from an installation.
     *
     * @link https://docs.github.com/rest/apps/installations#remove-a-repository-from-an-app-installation
     *
     * @param int $installationId
     * @param int $repositoryId
     *
     * @return array
     */
    public function removeRepository($installationId, $repositoryId)
    {
        return $this->delete('/installations/'.$installationId.'/repositories/'.$repositoryId);
    }

    /**
     * Get the currently authenticated app.
     *
     * @link https://docs.github.com/rest/apps/apps#get-the-authenticated-app
     *
     * @return array
     */
    public function getAuthenticatedApp()
    {
        return $this->get('/app');
    }

    /**
     * Manage the hook of an app.
     *
     * @link https://docs.github.com/rest/apps/webhooks
     *
     * @return Hook
     */
    public function hook()
    {
        return new Hook($this->getClient());
    }
}
