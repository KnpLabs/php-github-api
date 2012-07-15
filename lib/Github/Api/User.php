<?php

namespace Github\Api;

/**
 * Searching users, getting user information
 * and managing authenticated user account information.
 *
 * @link      http://develop.github.com/p/users.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class User extends Api
{
    /**
     * Search users by username:
     * @link http://developer.github.com/v3/search/#search-users
     *
     * @param  string $keyword the keyword to search
     *
     * @return array           list of users found
     */
    public function search($keyword)
    {
        return $this->get('legacy/user/search/'.urlencode($keyword));
    }

    /**
     * Get extended information about a user by its username
     * http://develop.github.com/p/users.html#getting_user_information
     *
     * @param   string  $username         the username to show
     * @return  array                     informations about the user
     */
    public function show($username)
    {
        return $this->get('users/'.urlencode($username));
    }

    /**
     * Update user informations. Requires authentication.
     * http://developer.github.com/v3/users/
     *
     * @param   array   $data             key=>value user attributes to update.
     *                                    key can be name, email, blog, company or location
     * @return  array                     informations about the user
     */
    public function update(array $data)
    {
        return $this->patch('user', $data);
    }

    /**
     * Request the users that a specific user is following
     * http://developer.github.com/v3/users/followers/
     *
     * @param   string  $username         the username
     * @return  array                     list of followed users
     */
    public function getFollowing($username)
    {
        return $this->get('users/'.urlencode($username).'/following');
    }

    /**
     * Request the users following a specific user
     * http://developer.github.com/v3/users/followers/
     *
     * @param   string  $username         the username
     * @return  array                     list of following users
     */
    public function getFollowers($username)
    {
        return $this->get('users/'.urlencode($username).'/followers');
    }

    /**
     * Make the authenticated user follow the specified user. Requires authentication.
     * http://developer.github.com/v3/users/followers/
     *
     * @param   string  $username         the username to follow
     * @return  array                     list of followed users
     */
    public function follow($username)
    {
        return $this->put('user/following/'.urlencode($username));
    }

    /**
     * Make the authenticated user unfollow the specified user. Requires authentication.
     * http://developer.github.com/v3/users/followers/
     *
     * @param   string  $username         the username to unfollow
     * @return  array                     list of followed users
     */
    public function unFollow($username)
    {
        return $this->delete('user/following/'.urlencode($username));
    }

    /**
     * Request the repos that a specific user is watching
     * http://develop.github.com/p/users.html#watched_repos
     *
     * @param   string  $username         the username
     * @return  array                     list of watched repos
     */
    public function getWatchedRepos($username)
    {
        return $this->get('users/'.urlencode($username).'/watched');
    }

    /**
     * Get the authenticated user public keys. Requires authentication
     *
     * @return  array                     list of public keys of the user
     */
    public function getKeys()
    {
        return $this->get('user/keys');
    }

    /**
     * Add a public key to the authenticated user. Requires authentication.
     *
     * @return  array                    list of public keys of the user
     */
    public function addKey($title, $key)
    {
        return $this->post('user/keys', array('title' => $title, 'key' => $key));
    }

    /**
     * Remove a public key from the authenticated user. Requires authentication.
     *
     * @return  array                    list of public keys of the user
     */
    public function removeKey($id)
    {
        return $this->delete('user/keys/'.urlencode($id));
    }

    /**
     * Get the authenticated user emails. Requires authentication.
     *
     * @return  array                     list of authenticated user emails
     */
    public function getEmails()
    {
        return $this->get('user/emails');
    }

    /**
     * Add an email to the authenticated user. Requires authentication.
     *
     * @return  array                     list of authenticated user emails
     */
    public function addEmail($email)
    {
        return $this->post('user/emails', array($email));
    }

    /**
     * Remove an email from the authenticated user. Requires authentication.
     *
     * @return  array                     list of authenticated user emails
     */
    public function removeEmail($email)
    {
        return $this->delete('user/emails', array($email));
    }
}
