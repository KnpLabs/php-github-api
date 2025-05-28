<?php
namespace ArgoCD\Api;

use ArgoCD\Model\AccountAccount;
use ArgoCD\Model\AccountAccountsList;
use ArgoCD\Model\AccountCanIResponse;
use ArgoCD\Model\AccountCreateTokenRequest;
use ArgoCD\Model\AccountCreateTokenResponse;
use ArgoCD\Model\AccountEmptyResponse;
use ArgoCD\Model\AccountUpdatePasswordRequest;
use ArgoCD\Model\AccountUpdatePasswordResponse;

class AccountService extends AbstractApi
{
    /**
     * Corresponds to AccountService_ListAccounts
     * Lists all accounts.
     *
     * @return AccountAccountsList
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function listAccounts(): AccountAccountsList
    {
        $responseArray = $this->get('/api/v1/account');
        return new AccountAccountsList($responseArray);
    }

    /**
     * Corresponds to AccountService_CanI
     * Checks if the current account has permission to perform an action.
     *
     * @param string $resource
     * @param string $action
     * @param string $subresource
     * @return AccountCanIResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function canI(string $resource, string $action, string $subresource): AccountCanIResponse
    {
        // The response for can-i is typically a raw string "yes" or "no".
        // The AbstractApi::get method expects JSON.
        // We need to handle this: either get() should allow raw responses,
        // or this method needs to handle potential JSON decode errors if the response isn't JSON.
        // For now, assuming get() returns the raw string if not JSON,
        // and AccountCanIResponse constructor can handle it.
        $response = $this->get(sprintf("/api/v1/account/can-i/%s/%s/%s", rawurlencode($resource), rawurlencode($action), rawurlencode($subresource)));
        
        // If $response is a string from get(), AccountCanIResponse constructor is designed to handle it.
        // If $response is an array (e.g. {'value': 'yes'}), it also handles it.
        return new AccountCanIResponse(is_array($response) ? $response : ['value' => $response]);
    }

    /**
     * Corresponds to AccountService_UpdatePassword
     * Updates the password for the current account or a specified account.
     *
     * @param string $name The name of the account to update. If updating the current user's password, this might be the username.
     * @param string $currentPassword The current password.
     * @param string $newPassword The new password.
     * @return AccountUpdatePasswordResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function updatePassword(string $name, string $currentPassword, string $newPassword): AccountUpdatePasswordResponse
    {
        $requestModel = new AccountUpdatePasswordRequest();
        $requestModel->setName($name); // Name of the account being updated
        $requestModel->setCurrentPassword($currentPassword);
        $requestModel->setNewPassword($newPassword);

        $responseArray = $this->put('/api/v1/account/password', $requestModel->toArray());
        return new AccountUpdatePasswordResponse($responseArray ?: []); // Response might be empty
    }

    /**
     * Corresponds to AccountService_GetAccount
     * Gets information about a specific account.
     *
     * @param string $name The name of the account.
     * @return AccountAccount
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function getAccount(string $name): AccountAccount
    {
        $responseArray = $this->get(sprintf("/api/v1/account/%s", rawurlencode($name)));
        return new AccountAccount($responseArray);
    }

    /**
     * Corresponds to AccountService_CreateToken
     * Creates a new token for the specified account.
     *
     * @param string $accountName The name of the account.
     * @param string $tokenId The desired ID/name for the token.
     * @param string $tokenDescription A description for the token.
     * @param string|null $expiresIn Duration string for token expiration (e.g., "30d", "24h", "0" for non-expiring).
     * @return AccountCreateTokenResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function createToken(string $accountName, string $tokenId, string $tokenDescription, ?string $expiresIn = "0"): AccountCreateTokenResponse
    {
        $requestModel = new AccountCreateTokenRequest();
        $requestModel->setId($tokenId); // This 'id' is the token's identifier
        $requestModel->setName($tokenDescription); // This 'name' is the token's description
        $requestModel->setExpiresIn($expiresIn);

        $responseArray = $this->post(sprintf("/api/v1/account/%s/token", rawurlencode($accountName)), $requestModel->toArray());
        return new AccountCreateTokenResponse($responseArray);
    }

    /**
     * Corresponds to AccountService_DeleteToken
     * Deletes a token for the specified account.
     *
     * @param string $accountName The name of the account.
     * @param string $tokenId The ID of the token to delete.
     * @return AccountEmptyResponse
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function deleteToken(string $accountName, string $tokenId): AccountEmptyResponse
    {
        $responseArray = $this->delete(sprintf("/api/v1/account/%s/token/%s", rawurlencode($accountName), rawurlencode($tokenId)));
        return new AccountEmptyResponse($responseArray ?: []); // Response is typically empty
    }
}
