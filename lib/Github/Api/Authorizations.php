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
        return $this->get('/authorizations/'.rawurlencode((string) $clientId));
    }

    /**
     * Create an authorization.
     *
     * @param null $OTPCode
     *
     * @return array|null
     */
    public function create(array $params, $OTPCode = null)
    {
        $headers = null === $OTPCode ? [] : ['X-GitHub-OTP' => $OTPCode];

        return $this->post('/authorizations', $params, $headers);
    }

    /**
     * Update an authorization.
     *
     * @return array|null
     */
    public function update($clientId, array $params)
    {
        return $this->patch('/authorizations/'.rawurlencode((string) $clientId), $params);
    }

    /**
     * Remove an authorization.
     *
     * @return array|null
     */
    public function remove($clientId)
    {
        return $this->delete('/authorizations/'.rawurlencode((string) $clientId));
    }

    /**
     * Check an authorization.
     *
     * @return array|null
     */
    public function check($clientId, $token)
    {
        return $this->get('/applications/'.rawurlencode((string) $clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Reset an authorization.
     *
     * @return array|null
     */
    public function reset($clientId, $token)
    {
        return $this->post('/applications/'.rawurlencode((string) $clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Remove an authorization.
     */
    public function revoke($clientId, $token)
    {
        $this->delete('/applications/'.rawurlencode((string) $clientId).'/tokens/'.rawurlencode($token));
    }

    /**
     * Revoke all authorizations.
     */
    public function revokeAll($clientId)
    {
        $this->delete('/applications/'.rawurlencode((string) $clientId).'/tokens');
    }
}
