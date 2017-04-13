<?php

namespace Github\Api;

/**
 * Creating, deleting and listing authorizations.
 *
 * @link   http://developer.github.com/v3/oauth_authorizations/
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Authorizations extends AbstractApi
{
    /**
     * List all authorizations.
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/authorizations');
    }

    /**
     * Show a single authorization.
     *
     * @param $clientId
     *
     * @return array
     */
    public function show($clientId)
    {
        return $this->get('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Create an authorization.
     *
     * @param array $params
     * @param null $OTPCode
     *
     * @return array
     */
    public function create(array $params, $OTPCode = null)
    {
        $headers = null === $OTPCode ? array() : array('X-GitHub-OTP' => $OTPCode);

        return $this->post('/authorizations', $params, $headers);
    }

    /**
     * Update an authorization.
     *
     * @param $clientId
     * @param array $params
     *
     * @return array
     */
    public function update($clientId, array $params)
    {
        return $this->patch('/authorizations/'.rawurlencode($clientId), $params);
    }

    /**
     * Remove an authorization.
     *
     * @param $clientId
     *
     * @return array
     */
    public function remove($clientId)
    {
        return $this->delete('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Check an authorization.
     *
     * @param $clientId
     * @param $token
     *
     * @return array
     */
    public function check($clientId, $token)
    {
        return $this->get('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Reset an authorization.
     *
     * @param $clientId
     * @param $token
     *
     * @return array
     */
    public function reset($clientId, $token)
    {
        return $this->post('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Remove an authorization.
     *
     * @param $clientId
     * @param $token
     */
    public function revoke($clientId, $token)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Revoke all authorizations.
     *
     * @param $clientId
     */
    public function revokeAll($clientId)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens');
    }
}
