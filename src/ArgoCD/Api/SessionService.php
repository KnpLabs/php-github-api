<?php
namespace ArgoCD\Api;

use ArgoCD\Model\SessionSessionCreateRequest;
use ArgoCD\Model\SessionSessionResponse;
use ArgoCD\Model\SessionGetUserInfoResponse;

class SessionService extends AbstractApi
{
    /**
     * Corresponds to SessionService_Create
     * Creates a new session for the specified user.
     *
     * @param string $username
     * @param string $password
     * @return SessionSessionResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function create(string $username, string $password): SessionSessionResponse
    {
        $requestModel = new SessionSessionCreateRequest();
        $requestModel->setUsername($username);
        $requestModel->setPassword($password);

        $responseArray = $this->post('/api/v1/session', $requestModel->toArray());

        return new SessionSessionResponse($responseArray);
    }

    /**
     * Corresponds to SessionService_Delete
     * Deletes the current session.
     *
     * @return SessionSessionResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function delete(): SessionSessionResponse
    {
        // The OpenAPI spec for delete /api/v1/session indicates a 200 response with sessionSessionResponse.
        // This is unusual for a DELETE operation (typically 204 No Content or an empty body),
        // but we will follow the spec.
        $responseArray = $this->delete('/api/v1/session');

        // If the response is truly empty (which is more typical for DELETE),
        // instantiating SessionSessionResponse with an empty array will result in a model with a null token.
        return new SessionSessionResponse($responseArray ?: []);
    }

    /**
     * Corresponds to SessionService_GetUserInfo
     * Gets information about the current user.
     *
     * @return SessionGetUserInfoResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function getUserInfo(): SessionGetUserInfoResponse
    {
        $responseArray = $this->get('/api/v1/session/userinfo');

        return new SessionGetUserInfoResponse($responseArray);
    }
}
