<?php

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
     * List emails for the authenticated user
     * @link http://developer.github.com/v3/users/emails/
     *
     * @param  int    $page       the page
     * @param  int    $perPage    the number of results by page
     *
     * @return array
     */
    public function all($page=1, $perPage=30)
    {
        $parameters = array(
            'page' => $page,
            'per_page' => $perPage
        );

        return $this->get('user/emails', $parameters);
    }

    /**
     * Adds one or more email for the authenticated user
     * @link http://developer.github.com/v3/users/emails/
     *
     * @param  string|array $emails
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function add($emails)
    {
        if (is_string($emails)) {
            $emails = array($emails);
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException();
        }

        return $this->post('user/emails', $emails);
    }

    /**
     * Removes one or more email for the authenticated user
     * @link http://developer.github.com/v3/users/emails/
     *
     * @param  string|array $emails
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function remove($emails)
    {
        if (is_string($emails)) {
            $emails = array($emails);
        } elseif (0 === count($emails)) {
            throw new InvalidArgumentException();
        }

        return $this->delete('user/emails', $emails);
    }
}
