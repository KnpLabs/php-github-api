<?php declare(strict_types=1);

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
     */
    public function all(): array
    {
        return $this->get('/authorizations');
    }

    /**
     * Show a single authorization.
     */
    public function show($clientId): array
    {
        return $this->get('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Create an authorization.
     *
     * @param null $OTPCode
     */
    public function create(array $params, $OTPCode = null): array
    {
        $headers = null === $OTPCode ? [] : ['X-GitHub-OTP' => $OTPCode];

        return $this->post('/authorizations', $params, $headers);
    }

    /**
     * Update an authorization.
     */
    public function update($clientId, array $params): array
    {
        return $this->patch('/authorizations/'.rawurlencode($clientId), $params);
    }

    /**
     * Remove an authorization.
     */
    public function remove($clientId): array
    {
        return $this->delete('/authorizations/'.rawurlencode($clientId));
    }

    /**
     * Check an authorization.
     */
    public function check($clientId, $token): array
    {
        return $this->get('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Reset an authorization.
     */
    public function reset($clientId, $token): array
    {
        return $this->post('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Remove an authorization.
     */
    public function revoke($clientId, $token)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Revoke all authorizations.
     */
    public function revokeAll($clientId)
    {
        $this->delete('/applications/'.rawurlencode($clientId).'/tokens');
    }
}
