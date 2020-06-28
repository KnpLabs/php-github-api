<?php

namespace Github\Api;

/**
 * Creating, deleting and listing authorizations.
 *
 * @link   http://developer.github.com/v3/oauth_authorizations/
 *
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Authorizations extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Check an application token.
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return array
     */
    public function checkToken($clientId, $token = null)
    {
        $this->configurePreviewHeader();

        return $this->post('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Reset an application token.
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return array
     */
    public function resetToken($clientId, $token = null)
    {
        $this->configurePreviewHeader();

        return $this->patch('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Revoke an application token.
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return void
     */
    public function deleteToken($clientId, $token = null)
    {
        $this->configurePreviewHeader();

        $this->delete('/applications/'.rawurlencode($clientId).'/token', $token ? ['access_token' => $token] : []);
    }

    /**
     * Revoke an application authorization.
     *
     * @param string      $clientId
     * @param string|null $token
     *
     * @return void
     */
    public function deleteGrant($clientId, $token = null)
    {
        $this->configurePreviewHeader();

        $this->delete('/applications/'.rawurlencode($clientId).'/grant', $token ? ['access_token' => $token] : []);
    }
}
