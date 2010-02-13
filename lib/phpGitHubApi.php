<?php

require_once(dirname(__FILE__).'/phpGitHubApiRequest.php');

/**
 * Simple PHP GitHubAPI class.
 * Usage: http://wiki.github.com/ornicar/php-github-api/
 *
 * @author	Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license	MIT License
 */
class phpGitHubApi
{
  protected
  $requestClass = 'phpGitHubApiRequest',
  $login,
  $token,
  $debug;

  /**
   * Instanciates a new API
   *
   * @param  bool   $debug  print debug messages
   */
  public function __construct($debug = false)
  {
    $this->debug = $debug;
  }

  /**
   * Authenticates a user for all next requests
   *
   * @param  string         $login  GitHub username
   * @param  string         $token  GitHub password
   * @return phpGitHubApi   $this   Fluent interface
   */
  public function authenticate($login, $token)
  {
    $this->login = $login;
    $this->token = $token;

    return $this;
  }

  /**
   * Search users by username
   * http://develop.github.com/p/users.html#searching_for_users
   *
   * @param   string  $username       the username to search
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function searchUsers($username, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('user/search/'.$username);

    return $data['users'];
  }

  /**
   * Get extended information about a user by its username
   * http://develop.github.com/p/users.html#getting_user_information
   *
   * @param   string  $username       the username to search
   * @param   array   $requestOptions request options
   * @return  array   informations about the user
   */
  public function showUser($username, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('user/show/'.$username);

    return $data['user'];
  }

  /**
   * List issues by username, repo and state
   * http://develop.github.com/p/issues.html#list_a_projects_issues
   *
   * @param   string  $username       the username
   * @param   string  $repo           the repo
   * @param   string  $state          the issue state, can be open or closed
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function listIssues($username, $repo, $state = 'open', array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('issues/list/'.$username.'/'.$repo.'/'.$state);

    return $data['issues'];
  }

  /**
   * Search issues by username, repo, state and search term
   * http://develop.github.com/p/issues.html#list_a_projects_issues
   *
   * @param   string  $username       the username
   * @param   string  $repo           the repo
   * @param   string  $state          the issue state, can be open or closed
   * @param   string  $searchTerm     the search term to filter issues by
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function searchIssues($username, $repo, $state, $searchTerm, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('issues/search/'.$username.'/'.$repo.'/'.$state.'/'.$searchTerm);

    return $data['issues'];
  }

  /**
   * Get extended information about an issue by its username, repo and number
   * http://develop.github.com/p/issues.html#view_an_issue
   *
   * @param   string  $username       the username
   * @param   string  $repo           the repo
   * @param   string  $number         the issue number
   * @return  array   informations about the issue
   */
  public function showIssue($username, $repo, $number, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('issues/show/'.$username.'/'.$repo.'/'.$number);

    return $data['issue'];
  }

  /**
   * List commits by username, repo and branch
   * http://develop.github.com/p/commits.html#listing_commits_on_a_branch
   *
   * @param   string  $username       the username
   * @param   string  $repo           the repo
   * @param   string  $branch         the branch
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function listBranchCommits($username, $repo, $branch, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('commits/list/'.$username.'/'.$repo.'/'.$branch);

    return $data['commits'];
  }

  /**
   * List commits by username, repo, branch and path
   * http://develop.github.com/p/commits.html#listing_commits_for_a_file
   *
   * @param   string  $username       the username
   * @param   string  $repo           the repo
   * @param   string  $branch         the branch
   * @param   array   $requestOptions request options
   * @return  array   list of users found
   */
  public function listFileCommits($username, $repo, $branch, $path, array $requestOptions = array())
  {
    $data = $this
    ->createRequest($requestOptions)
    ->get('commits/list/'.$username.'/'.$repo.'/'.$branch.'/'.$path);

    return $data['commits'];
  }

  /**
   * Get data from any route, GET method
   * Ex: $api->get('repos/show/my-username/my-repo')
   *
   * @param   string  $route          the GitHub route
   * @param   array   $requestOptions request options
   * @return  array   data returned
   */
  public function get($route, array $requestOptions = array())
  {
    return $this
    ->createRequest($requestOptions)
    ->get($route);
  }

  /**
   * Get data from any route, POST method
   * Ex: $api->get('repos/show/my-username/my-repo')
   *
   * @param   string  $route          the GitHub route
   * @param   array   $requestOptions request options
   * @return  array   data returned
   */
  public function post($route, array $requestOptions = array())
  {
    return $this
    ->createRequest($requestOptions)
    ->post($route);
  }

  /**
   * Creates a new request
   *
   * @param   array               $options  the request options
   * @return  phpGitHubApiRequest a request instance
   */
  protected function createRequest(array $options = array())
  {
    $options = array_merge(array(
      'login' => $this->login,
      'token' => $this->token,
      'debug' => $this->debug
    ), $options);
    
    return new $this->requestClass($options);
  }

}