<?php declare(strict_types=1);

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;

/**
 * @link   http://developer.github.com/v3/users/emails/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Emails extends AbstractApi
{
    /**
     * List emails for the authenticated user.
     *
     * @link http://developer.github.com/v3/users/emails/
     */
    public function all(): array
    {
        return $this->get('/user/emails');
    }

    /**
     * List public email addresses for a user.
     *
     * @link https://developer.github.com/v3/users/emails/#list-public-email-addresses-for-a-user
     *
     * @return array
     */
    public function allPublic()
    {
        return $this->get('/user/public_emails');
    }

    /**
     * Adds one or more email for the authenticated user.
     *
     * @link http://developer.github.com/v3/users/emails/
     *
     * @param string|array $emails
     *
     * @throws \Github\Exception\InvalidArgumentException
     */
    public function add($emails): array
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException();
        }

        return $this->post('/user/emails', $emails);
    }

    /**
     * Removes one or more email for the authenticated user.
     *
     * @link http://developer.github.com/v3/users/emails/
     *
     * @param string|array $emails
     *
     * @throws \Github\Exception\InvalidArgumentException
     */
    public function remove($emails): array
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException();
        }

        return $this->delete('/user/emails', $emails);
    }

    /**
     * Toggle primary email visibility
     *
     * @link https://developer.github.com/v3/users/emails/#toggle-primary-email-visibility
     *
     * @return array
     */
    public function toggleVisibility()
    {
        return $this->patch('/user/email/visibility');
    }
}
