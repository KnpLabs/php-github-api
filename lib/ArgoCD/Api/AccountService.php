<?php
namespace ArgoCD\Api;

// Model imports removed

class AccountService extends AbstractApi
{
    /**
     * Corresponds to AccountService_ListAccounts
     * Lists all accounts.
     *
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function listAccounts(): array
    {
        return $this->get('/api/v1/account');
    }

    /**
     * Corresponds to AccountService_CanI
     * Checks if the current account has permission to perform an action.
     *
     * @param string $resource
     * @param string $action
     * @param string $subresource
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function canI(string $resource, string $action, string $subresource): array
    {
        $response = $this->get(sprintf("/api/v1/account/can-i/%s/%s/%s", rawurlencode($resource), rawurlencode($action), rawurlencode($subresource)));
        
        // If $response is a string from get(), convert to array format.
        // Otherwise, it's assumed to be already an array (e.g. from JSON response).
        return is_array($response) ? $response : ['value' => $response];
    }

    /**
     * Corresponds to AccountService_UpdatePassword
     * Updates the password for the current account or a specified account.
     *
     * @param string $name The name of the account to update.
     * @param string $currentPassword The current password.
     * @param string $newPassword The new password.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function updatePassword(string $name, string $currentPassword, string $newPassword): array
    {
        $body = [
            'name' => $name,
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
        ];

        return $this->put('/api/v1/account/password', $body);
    }

    /**
     * Corresponds to AccountService_GetAccount
     * Gets information about a specific account.
     *
     * @param string $name The name of the account.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function getAccount(string $name): array
    {
        return $this->get(sprintf("/api/v1/account/%s", rawurlencode($name)));
    }

    /**
     * Corresponds to AccountService_CreateToken
     * Creates a new token for the specified account.
     *
     * @param string $accountName The name of the account (used in URL path).
     * @param string $tokenId The desired ID/name for the token (maps to 'id' in request body).
     * @param string $tokenNameOrDescription A description for the token (maps to 'name' in request body).
     * @param string|null $expiresIn Duration string for token expiration (e.g., "30d", "24h", "0" for non-expiring).
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function createToken(string $accountName, string $tokenId, string $tokenNameOrDescription, ?string $expiresIn = "0"): array
    {
        $body = [
            'id' => $tokenId,
            'name' => $tokenNameOrDescription,
            'expiresIn' => $expiresIn,
        ];

        return $this->post(sprintf("/api/v1/account/%s/token", rawurlencode($accountName)), $body);
    }

    /**
     * Corresponds to AccountService_DeleteToken
     * Deletes a token for the specified account.
     *
     * @param string $accountName The name of the account.
     * @param string $tokenId The ID of the token to delete.
     * @return array
     * @throws \ArgoCD\Exception\RuntimeException
     */
    public function deleteToken(string $accountName, string $tokenId): array
    {
        return $this->delete(sprintf("/api/v1/account/%s/token/%s", rawurlencode($accountName), rawurlencode($tokenId)));
    }
}
