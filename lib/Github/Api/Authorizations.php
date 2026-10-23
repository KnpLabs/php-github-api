<?php

namespace Github\Api;

/**
 * Creating, deleting and listing authorizations.
 *
 * @link   https://docs.github.com/rest/apps/oauth-applications
 *
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Authorizations extends AbstractApi
{
    /**
     * Check an application token.
     *
     * @link https://docs.github.com/rest/apps/oauth-applications#check-a-token
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return array
     */
    public function checkToken($clientId, $token = null)
    {
        return $this->post('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Reset an application token.
     *
     * @link https://docs.github.com/rest/apps/oauth-applications#reset-a-token
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return array
     */
    public function resetToken($clientId, $token = null)
    {
        return $this->patch('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Revoke an application token.
     *
     * @link https://docs.github.com/rest/apps/oauth-applications#delete-an-app-token
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return void
     */
    public function deleteToken($clientId, $token = null)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Revoke an application authorization.
     *
     * @link https://docs.github.com/rest/apps/oauth-applications#delete-an-app-authorization
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return void
     */
    public function deleteGrant($clientId, $token = null)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/grant', $token ? ['access_token' => $token] : []);
    }
}
