<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;

/**
 * @link   https://docs.github.com/rest/users/emails
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Emails extends AbstractApi
{
    /**
     * List emails for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/emails#list-email-addresses-for-the-authenticated-user
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/user/emails');
    }

    /**
     * List public email addresses for a user.
     *
     * @link https://docs.github.com/rest/users/emails#list-public-email-addresses-for-the-authenticated-user
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
     * @link https://docs.github.com/rest/users/emails#add-an-email-address-for-the-authenticated-user
     *
     * @param string|array $emails
     *
     * @throws \Github\Exception\InvalidArgumentException
     *
     * @return array
     */
    public function add($emails)
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException('The user emails parameter should be a single email or an array of emails');
        }

        return $this->post('/user/emails', $emails);
    }

    /**
     * Removes one or more email for the authenticated user.
     *
     * @link https://docs.github.com/rest/users/emails#delete-an-email-address-for-the-authenticated-user
     *
     * @param string|array $emails
     *
     * @throws \Github\Exception\InvalidArgumentException
     *
     * @return array
     */
    public function remove($emails)
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException('The user emails parameter should be a single email or an array of emails');
        }

        return $this->delete('/user/emails', $emails);
    }

    /**
     * Toggle primary email visibility.
     *
     * @link https://docs.github.com/rest/users/emails#set-primary-email-visibility-for-the-authenticated-user
     *
     * @return array
     */
    public function toggleVisibility()
    {
        return $this->patch('/user/email/visibility');
    }
}
