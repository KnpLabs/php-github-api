<?php

require_once(dirname(__FILE__).'/phpGitHubApiAbstract.php');

/**
 * Searching users, getting user information and managing authenticated user account information.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiUser extends phpGitHubApiAbstract
{
  /**
   * Search users by username
   * http://develop.github.com/p/users.html#searching_for_users
   *
   * @param   string  $username         the username to search
   * @return  array                     list of users found
   */
  public function search($username)
  {
    $response = $this->api->get('user/search/'.$username);

    return $response['users'];
  }

  /**
   * Get extended information about a user by its username
   * http://develop.github.com/p/users.html#getting_user_information
   *
   * @param   string  $username         the username to search
   * @return  array                     informations about the user
   */
  public function show($username)
  {
    $response = $this->api->get('user/show/'.$username);

    return $response['user'];
  }

  /**
   * Update user informations. Requires authentication.
   * http://develop.github.com/p/users.html#authenticated_user_management
   *
   * @param   string  $username         the username to search
   * @param   array   $data             key=>value user attributes to update.
   *                                    key can be name, email, blog, company or location
   * @return  array                     informations about the user
   */
  public function update($username, array $data)
  {
    $response = $this->api->post('user/show/'.$username, array('values' => $data));

    return $response['user'];
  }
}