<?php
namespace ArgoCD\Api;

// Model imports removed

class SessionService extends AbstractApi
{
    /**
     * Corresponds to SessionService_Create
     * Creates a new session for the specified user.
     *
     * @param string $username
     * @param string $password
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function create(string $username, string $password): array
    {
        $body = [
            'username' => $username,
            'password' => $password,
        ];

        return $this->post('/api/v1/session', $body);
    }

    /**
     * Corresponds to SessionService_Delete
     * Deletes the current session.
     *
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function delete(): array
    {
        // The OpenAPI spec for delete /api/v1/session indicates a 200 response with sessionSessionResponse.
        // This is unusual for a DELETE operation (typically 204 No Content or an empty body),
        // but we will follow the spec.
        // The AbstractApi::delete method should return an array, even if empty.
        return $this->delete('/api/v1/session');
    }

    /**
     * Corresponds to SessionService_GetUserInfo
     * Gets information about the current user.
     *
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function getUserInfo(): array
    {
        return $this->get('/api/v1/session/userinfo');
    }
}
