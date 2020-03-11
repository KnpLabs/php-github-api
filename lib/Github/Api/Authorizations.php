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

    private function configurePreviewHeader()
    {
        $this->acceptHeaderValue = 'application/vnd.github.doctor-strange-preview+json';
    }

    /**
     * List all authorizations.
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 13th November 2020. No replacement will be offered. The "web application flow" should be used instead.
     */
    public function all()
    {
        return $this->get('/authorizations');
    }

    /**
     * Show a single authorization.
     *
     * @param string $clientId
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 13th November 2020. No replacement will be offered. The "web application flow" should be used instead.
     */
    public function show($clientId)
    {
        return $this->get('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Create an authorization.
     *
     * @param array       $params
     * @param string|null $OTPCode
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 13th November 2020. No replacement will be offered. The "web application flow" should be used instead.
     */
    public function create(array $params, $OTPCode = null)
    {
        $headers = null === $OTPCode ? [] : ['X-GitHub-OTP' => $OTPCode];

        return $this->post('/authorizations', $params, $headers);
    }

    /**
     * Update an authorization.
     *
     * @param string $clientId
     * @param array  $params
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 13th November 2020. No replacement will be offered. The "web application flow" should be used instead.
     */
    public function update($clientId, array $params)
    {
        return $this->patch('/authorizations/'.rawurlencode($clientId), $params);
    }

    /**
     * Remove an authorization.
     *
     * @param string $clientId
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 13th November 2020. No replacement will be offered. The "web application flow" should be used instead.
     */
    public function remove($clientId)
    {
        return $this->delete('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Check an authorization.
     *
     * @param string $clientId
     * @param string $token
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 1st July 2020. Use self::checkToken() instead.
     */
    public function check($clientId, $token)
    {
        return $this->get('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

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
     * Reset an authorization.
     *
     * @param string $clientId
     * @param string $token
     *
     * @return array
     *
     * @deprecated GitHub will remove this endpoint on 1st July 2020. Use self::resetToken() instead.
     */
    public function reset($clientId, $token)
    {
        return $this->post('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
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
     * Remove an authorization.
     *
     * @param string $clientId
     * @param string $token
     *
     * @deprecated GitHub will remove this endpoint on 1st July 2020. Use self::deleteToken() instead.
     */
    public function revoke($clientId, $token)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Revoke all authorizations.
     *
     * @param string $clientId
     *
     * @deprecated GitHub will remove this endpoint on 1st July 2020. Use self::deleteGrant() instead.
     */
    public function revokeAll($clientId)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens');
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
