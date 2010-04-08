<?php

require_once(dirname(__FILE__).'/phpGitHubApiRequest.php');

/**
 * Simple PHP GitHub API class.
 * Usage: http://wiki.github.com/ornicar/php-github-api/
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license    MIT License
 */
class phpGitHubApi
{
  protected
  $requestClass   = 'phpGitHubApiRequest',
  $requestOptions = array(),
  $debug;

  /**
   * Instanciates a new API
   *
   * @param  bool           $debug      print debug messages
   */
  public function __construct($debug = false)
  {
    $this->debug = $debug;
    $this->requestOptions['debug'] = $debug;
  }

  /**
   * Authenticates a user for all next requests
   *
   * @param  string         $login      GitHub username
   * @param  string         $token      GitHub private token
   * @return phpGitHubApi               fluent interface
   */
  public function authenticate($login, $token)
  {
    $this->requestOptions['login'] = $login;
    $this->requestOptions['token'] = $token;

    return $this;
  }

  /**
   * Deauthenticates a user for all next requests
   *
   * @return phpGitHubApi               fluent interface
   */
  public function deAuthenticate()
  {
    unset($this->requestOptions['login'], $this->requestOptions['token']);

    return $this;
  }

  /**
   * Search users by username
   * http://develop.github.com/p/users.html#searching_for_users
   *
   * @param   string  $username         the username to search
   * @return  array                     list of users found
   */
  public function searchUsers($username)
  {
    $response = $this->get('user/search/'.$username);

    return $response['users'];
  }

  /**
   * Get extended information about a user by its username
   * http://develop.github.com/p/users.html#getting_user_information
   *
   * @param   string  $username         the username to search
   * @return  array                     informations about the user
   */
  public function showUser($username)
  {
    $response = $this->get('user/show/'.$username);

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
  public function updateUser($username, array $data)
  {
    $response = $this->post('user/show/'.$username, array('values' => $data));

    return $response['user'];
  }

  /**
   * List issues by username, repo and state
   * http://develop.github.com/p/issues.html#list_a_projects_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $state            the issue state, can be open or closed
   * @return  array                     list of users found
   */
  public function listIssues($username, $repo, $state = 'open')
  {
    $response = $this->get('issues/list/'.$username.'/'.$repo.'/'.$state);

    return $response['issues'];
  }

  /**
   * Search issues by username, repo, state and search term
   * http://develop.github.com/p/issues.html#list_a_projects_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $state            the issue state, can be open or closed
   * @param   string  $searchTerm       the search term to filter issues by
   * @return  array                     list of users found
   */
  public function searchIssues($username, $repo, $state, $searchTerm)
  {
    $response = $this->get('issues/search/'.$username.'/'.$repo.'/'.$state.'/'.$searchTerm);

    return $response['issues'];
  }

  /**
   * Get extended information about an issue by its username, repo and number
   * http://develop.github.com/p/issues.html#view_an_issue
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $number           the issue number
   * @return  array                     informations about the issue
   */
  public function showIssue($username, $repo, $number)
  {
    $response = $this->get('issues/show/'.$username.'/'.$repo.'/'.$number);

    return $response['issue'];
  }

  /**
   * List commits by username, repo and branch
   * http://develop.github.com/p/commits.html#listing_commits_on_a_branch
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $branch           the branch
   * @return  array                     list of users found
   */
  public function listBranchCommits($username, $repo, $branch)
  {
    $response = $this->get('commits/list/'.$username.'/'.$repo.'/'.$branch);

    return $response['commits'];
  }

  /**
   * List commits by username, repo, branch and path
   * http://develop.github.com/p/commits.html#listing_commits_for_a_file
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $branch           the branch
   * @param   string  $path             the path
   * @return  array                     list of users found
   */
  public function listFileCommits($username, $repo, $branch, $path)
  {
    $response = $this->get('commits/list/'.$username.'/'.$repo.'/'.$branch.'/'.$path);

    return $response['commits'];
  }

  /**
   * Get a listing of the root tree of a project by the username, repo, and tree SHA
   * http://develop.github.com/p/object.html#trees
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @return  array                     root tree of the project
   */
  public function listObjectTree($username, $repo, $treeSHA)
  {
    $response = $this->get('tree/show/'.$username.'/'.$repo.'/'.$treeSHA);

    return $response['tree'];
  }
  
  /**
   * Get the data about a blob by tree SHA and file path.
   * http://develop.github.com/p/object.html#blobs
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @param   string $path              the path
   * @return  array                     data blob of tree and path
   */
  public function showObjectBlob($username, $repo, $treeSHA, $path)
  {
    $response = $this->get('blob/show/'.$username.'/'.$repo.'/'.$treeSHA .'/'.$path);

    return $response['blob'];
  }
  
  /**
   * Lists the data blobs of a tree by tree SHA
   * http://develop.github.com/p/object.html#blobs
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @param   string $path              the path
   * @return  array                     data blobs of tree
   */
  public function listObjectBlobs($username, $repo, $treeSHA)
  {
    $response = $this->get('blob/all/'.$username.'/'.$repo.'/'.$treeSHA);

    return $response['blobs'];
  }
  
  /**
   * Call any route, GET method
   * Ex: $api->get('repos/show/my-username/my-repo')
   *
   * @param   string  $route            the GitHub route
   * @param   array   $parameters       GET parameters
   * @return  array                     data returned
   */
  public function get($route, array $parameters = array())
  {
    return $this->createRequest()->get($route, $parameters);
  }

  /**
   * Call any route, POST method
   * Ex: $api->post('repos/show/my-username', array('email' => 'my-new-email'))
   *
   * @param   string  $route            the GitHub route
   * @param   array   $parameters       POST parameters
   * @return  array                     data returned
   */
  public function post($route, array $parameters = array())
  {
    return $this->createRequest()->post($route, $parameters);
  }

  /**
   * Creates a new request
   *
   * @return  phpGitHubApiRequest a request instance
   */
  protected function createRequest()
  {
    return new $this->requestClass($this->getRequestOptions());
  }

  /**
   * Get the request class
   *
   * @return  string  the request class
   */
  public function getRequestClass()
  {
    return $this->requestClass;
  }

  /**
   * Set the request class
   *
   * @param   string        $requestClass   the new request class
   * @return  phpGitHubApi                  fluent interface
   */
  public function setRequestClass($requestClass)
  {
    $this->requestClass = $requestClass;

    return $this;
  }

  /**
   * Get the request options
   *
   * @return  array  the request options
   */
  public function getRequestOptions()
  {
    return $this->requestOptions;
  }

  /**
   * Set the request options
   *
   * @param   array        $requestOptions    the new request options
   * @return  phpGitHubApi                    fluent interface
   */
  public function setRequestOptions($requestOptions)
  {
    $this->requestOptions = $requestOptions;

    return $this;
  }

}