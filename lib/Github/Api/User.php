<?php

namespace Github\Api;

use Github\Api\User\Migration;

/**
 * Searching users, getting user information.
 *
 * @link   https://docs.github.com/rest/users/users
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 */
class User extends AbstractApi
{
    /**
     * Request all users.
     *
     * @link https://docs.github.com/rest/users/users#list-users
     *
     * @param int|null $id ID of the last user that you've seen
     *
     * @return array list of users found
     */
    public function all($id = null)
    {
        if (!is_int($id)) {
            return $this->get('/users');
        }

        return $this->get('/users', ['since' => $id]);
    }

    /**
     * Get extended information about a user by its username.
     *
     * @link https://docs.github.com/rest/users/users#get-a-user
     *
     * @param string $username the username to show
     *
     * @return array information about the user
     */
    public function show($username)
    {
        return $this->get('/users/'.rawurlencode($username));
    }

    /**
     * Get extended information about a user by its id.
     * Note: at time of writing this is an undocumented feature but GitHub support have advised that it can be relied on.
     *
     * @link https://docs.github.com/rest/users/users#get-a-user-using-their-id
     *
     * @param int $id the id of the user to show
     *
     * @return array information about the user
     */
    public function showById($id)
    {
        return $this->get('/user/'.$id);
    }

    /**
     * Get extended information about a user by its username.
     *
     * @link https://docs.github.com/rest/orgs/orgs#list-organizations-for-a-user
     *
     * @param string $username the username to show
     *
     * @return array information about organizations that user belongs to
     */
    public function organizations($username)
    {
        return $this->get('/users/'.rawurlencode($username).'/orgs');
    }

    /**
     * Get user organizations.
     *
     * @link https://docs.github.com/rest/orgs/orgs#list-organizations-for-the-authenticated-user
     *
     * @return array information about organizations that authenticated user belongs to
     */
    public function orgs()
    {
        return $this->get('/user/orgs');
    }

    /**
     * Request the users that a specific user is following.
     *
     * @link https://docs.github.com/rest/users/followers#list-the-people-a-user-follows
     *
     * @param string $username       the username
     * @param array  $parameters     parameters for the query string
     * @param array  $requestHeaders additional headers to set in the request
     *
     * @return array list of followed users
     */
    public function following($username, array $parameters = [], array $requestHeaders = [])
    {
        return $this->get('/users/'.rawurlencode($username).'/following', $parameters, $requestHeaders);
    }

    /**
     * Request the users following a specific user.
     *
     * @link https://docs.github.com/rest/users/followers#list-followers-of-a-user
     *
     * @param string $username       the username
     * @param array  $parameters     parameters for the query string
     * @param array  $requestHeaders additional headers to set in the request
     *
     * @return array list of following users
     */
    public function followers($username, array $parameters = [], array $requestHeaders = [])
    {
        return $this->get('/users/'.rawurlencode($username).'/followers', $parameters, $requestHeaders);
    }

    /**
     * Request starred repositories that a specific user has starred.
     *
     * @link https://docs.github.com/rest/activity/starring#list-repositories-starred-by-a-user
     *
     * @param string $username  the username
     * @param int    $page      the page number of the paginated result set
     * @param int    $perPage   the number of results per page
     * @param string $sort      sort by (possible values: created, updated)
     * @param string $direction direction of sort (possible values: asc, desc)
     *
     * @return array list of starred repositories
     */
    public function starred($username, $page = 1, $perPage = 30, $sort = 'created', $direction = 'desc')
    {
        return $this->get('/users/'.rawurlencode($username).'/starred', [
            'page' => $page,
            'per_page' => $perPage,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Request the repository that a specific user is watching.
     *
     * @link https://docs.github.com/rest/activity/watching#list-repositories-watched-by-a-user
     *
     * @param string $username the username
     *
     * @return array list of watched repositories
     */
    public function subscriptions($username)
    {
        return $this->get('/users/'.rawurlencode($username).'/subscriptions');
    }

    /**
     * List public repositories for the specified user.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repositories-for-a-user
     *
     * @param string $username    the username
     * @param string $type        role in the repository
     * @param string $sort        sort by
     * @param string $direction   direction of sort, asc or desc
     * @param string $visibility  visibility of repository
     * @param string $affiliation relationship to repository
     *
     * @return array list of the user repositories
     */
    public function repositories($username, $type = 'owner', $sort = 'full_name', $direction = 'asc', $visibility = 'all', $affiliation = 'owner,collaborator,organization_member')
    {
        return $this->get('/users/'.rawurlencode($username).'/repos', [
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction,
            'visibility' => $visibility,
            'affiliation' => $affiliation,
        ]);
    }

    /**
     * List repositories that are accessible to the authenticated user.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repositories-for-the-authenticated-user
     *
     * @param array $params visibility, affiliation, type, sort, direction
     *
     * @return array list of the user repositories
     */
    public function myRepositories(array $params = [])
    {
        return $this->get('/user/repos', $params);
    }

    /**
     * Get the public gists for a user.
     *
     * @link https://docs.github.com/rest/gists/gists#list-gists-for-a-user
     *
     * @param string $username the username
     *
     * @return array list of the user gists
     */
    public function gists($username)
    {
        return $this->get('/users/'.rawurlencode($username).'/gists');
    }

    /**
     * Get the public keys for a user.
     *
     * @link https://docs.github.com/rest/users/keys#list-public-keys-for-a-user
     *
     * @param string $username the username
     *
     * @return array list of the user public keys
     */
    public function keys($username)
    {
        return $this->get('/users/'.rawurlencode($username).'/keys');
    }

    /**
     * List events performed by a user.
     *
     * @link https://docs.github.com/rest/activity/events#list-public-events-for-a-user
     *
     * @param string $username
     *
     * @return array
     */
    public function publicEvents($username)
    {
        return $this->get('/users/'.rawurlencode($username).'/events/public');
    }

    /**
     * List events performed by an authenticated user.
     *
     * @link https://docs.github.com/rest/activity/events#list-events-for-the-authenticated-user
     *
     * @return array
     */
    public function events(string $username)
    {
        return $this->get('/users/'.rawurlencode($username).'/events');
    }

    /**
     * @return Migration
     */
    public function migration(): Migration
    {
        return new Migration($this->getClient());
    }
}
