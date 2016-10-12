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
}
