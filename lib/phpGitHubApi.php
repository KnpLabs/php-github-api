<?php

/**
 * Simple PHP GitHub API
 *
 * @tutorial  http://github.com/ornicar/php-github-api/blob/master/README.markdown
 * @version   2.12 2010-10-17
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 *
 * Website: http://github.com/ornicar/php-github-api
 * Tickets: http://github.com/ornicar/php-github-api/issues
 */
class phpGitHubApi
{
  /**
   * Constant for authentication method. Indicates the default, but deprecated
   * login with username and token in URL.
   */
  const AUTH_URL_TOKEN = 'url_token';

  /**
   * Constant for authentication method. Indicates the new favored login method
   * with username and password via HTTP Authentication.
   */
  const AUTH_HTTP_PASSWORD = 'http_password';

  /**
   * Constant for authentication method. Indicates the new login method with
   * with username and token via HTTP Authentication.
   */
  const AUTH_HTTP_TOKEN = 'http_token';

  /**
   * The request instance used to communicate with GitHub
   * @var phpGitHubApiRequest
   */
  protected $request  = null;

  /**
   * The list of loaded API instances
   * @var array
   */
  protected $apis     = array();

  /**
   * Use debug mode (prints debug messages)
   * @var bool
   */
  protected $debug;

  /**
   * Instanciate a new GitHub API
   *
   * @param  bool           $debug      print debug messages
   */
  public function __construct($debug = false)
  {
    $this->debug = $debug;
  }

  /**
   * Authenticate a user for all next requests
   *
   * @param  string         $login      GitHub username
   * @param  string         $secret     GitHub private token or Github password if $method == AUTH_HTTP_PASSWORD
   * @param  string         $method     One of the AUTH_* class constants
   *
   * @return phpGitHubApi               fluent interface
   */
  public function authenticate($login, $secret, $method = NULL)
  {
    if (!$method) {
      $method = self::AUTH_URL_TOKEN;
    }
    $this->getRequest()
    ->setOption('auth_method', $method)
    ->setOption('login', $login)
    ->setOption('secret', $secret);

    return $this;
  }

  /**
   * Deauthenticate a user for all next requests
   *
   * @return phpGitHubApi               fluent interface
   */
  public function deAuthenticate()
  {
    return $this->authenticate(null, null, null);
  }

  /**
   * Call any route, GET method
   * Ex: $api->get('repos/show/my-username/my-repo')
   *
   * @param   string  $route            the GitHub route
   * @param   array   $parameters       GET parameters
   * @param   array   $requestOptions   reconfigure the request
   * @return  array                     data returned
   */
  public function get($route, array $parameters = array(), $requestOptions = array())
  {
    return $this->getRequest()->get($route, $parameters, $requestOptions);
  }

  /**
   * Call any route, POST method
   * Ex: $api->post('repos/show/my-username', array('email' => 'my-new-email@provider.org'))
   *
   * @param   string  $route            the GitHub route
   * @param   array   $parameters       POST parameters
   * @param   array   $requestOptions   reconfigure the request
   * @return  array                     data returned
   */
  public function post($route, array $parameters = array(), $requestOptions = array())
  {
    return $this->getRequest()->post($route, $parameters, $requestOptions);
  }

  /**
   * Get the request
   *
   * @return  phpGitHubApiRequest   a request instance
   */
  public function getRequest()
  {
    if(!isset($this->request))
    {
      require_once(dirname(__FILE__).'/request/phpGitHubApiRequest.php');
      $this->request = new phpGitHubApiRequest(array(
        'debug' => $this->debug
      ));
    }

    return $this->request;
  }

  /**
   * Inject another request
   *
   * @param   phpGitHubApiRequest   a request instance
   * @return  phpGitHubApi          fluent interface
   */
  public function setRequest(phpGitHubApiRequest $request)
  {
    $this->request = $request;

    return $this;
  }

  /**
   * Get the user API
   *
   * @return  phpGitHubApiUser    the user API
   */
  public function getUserApi()
  {
    if(!isset($this->apis['user']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiUser.php');
      $this->apis['user'] = new phpGitHubApiUser($this);
    }

    return $this->apis['user'];
  }

  /**
   * Get the issue API
   *
   * @return  phpGitHubApiIssue   the issue API
   */
  public function getIssueApi()
  {
    if(!isset($this->apis['issue']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiIssue.php');
      $this->apis['issue'] = new phpGitHubApiIssue($this);
    }

    return $this->apis['issue'];
  }

  /**
   * Get the commit API
   *
   * @return  phpGitHubApiCommit  the commit API
   */
  public function getCommitApi()
  {
    if(!isset($this->apis['commit']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiCommit.php');
      $this->apis['commit'] = new phpGitHubApiCommit($this);
    }

    return $this->apis['commit'];
  }

  /**
   * Get the repo API
   *
   * @return  phpGitHubRepoCommit  the repo API
   */
  public function getRepoApi()
  {
    if(!isset($this->apis['repo']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiRepo.php');
      $this->apis['repo'] = new phpGitHubApiRepo($this);
    }

    return $this->apis['repo'];
  }

  /**
   * Get the organization API
   *
   * @return  phpGitHubApiOrganization  the object API
   */
  public function getOrganizationApi()
  {
    if(!isset($this->apis['organization']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiOrganization.php');
      $this->apis['organization'] = new phpGitHubApiOrganization($this);
    }

    return $this->apis['organization'];
  }

  /**
   * Get the object API
   *
   * @return  phpGitHubApiObject  the object API
   */
  public function getObjectApi()
  {
    if(!isset($this->apis['object']))
    {
      require_once(dirname(__FILE__).'/api/phpGitHubApiObject.php');
      $this->apis['object'] = new phpGitHubApiObject($this);
    }

    return $this->apis['object'];
  }

  /**
   * Inject another API instance
   *
   * @param   string                $name the API name
   * @param   phpGitHubApiAbstract  $api  the API instance
   * @return  phpGitHubApi                fluent interface
   */
  public function setApi($name, phpGitHubApiAbstract $instance)
  {
    $this->apis[$name] = $instance;

    return $this;
  }

  /**
   * Get any API
   *
   * @param   string                $name the API name
   * @return  phpGitHubApiAbstract        the API instance
   */
  public function getApi($name)
  {
    return $this->apis[$name];
  }

  /**
   * DEPRECATED METHODS (BC COMPATIBILITY)
   */

  /**
   * @deprecated  use ->getUserApi()->search()
   * @see         phpGitHubApiUser::search()
   */
  public function searchUsers($username)
  {
    return $this->getUserApi()->search($username);
  }

  /**
   * @deprecated  use ->getUserApi()->show()
   * @see         phpGitHubApiUser::show()
   */
  public function showUser($username)
  {
    return $this->getUserApi()->show($username);
  }

  /**
   * @deprecated  use ->getIssueApi()->getList()
   * @see         phpGitHubApiIssue::getList()
   */
  public function listIssues($username, $repo, $state = 'open')
  {
    return $this->getIssueApi()->getList($username, $repo, $state);
  }

  /**
   * @deprecated  use ->getIssueApi()->search()
   * @see         phpGitHubApiIssue::search()
   */
  public function searchIssues($username, $repo, $state, $searchTerm)
  {
    return $this->getIssueApi()->search($username, $repo, $state, $searchTerm);
  }

  /**
   * @deprecated  use ->getIssueApi()->show()
   * @see         phpGitHubApiIssue::show()
   */
  public function showIssue($username, $repo, $number)
  {
    return $this->getIssueApi()->show($username, $repo, $number);
  }

  /**
   * @deprecated  use ->getCommitApi()->getBranchCommits()
   * @see         phpGitHubApiCommit::getBranchCommits()
   */
  public function listBranchCommits($username, $repo, $branch)
  {
    return $this->getCommitApi()->getBranchCommits($username, $repo, $branch);
  }

  /**
   * @deprecated  use ->getCommitApi()->getFileCommits()
   * @see         phpGitHubApiCommit::getFileCommits()
   */
  public function listFileCommits($username, $repo, $branch, $path)
  {
    return $this->getCommitApi()->getFileCommits($username, $repo, $branch, $path);
  }

  /**
   * @deprecated  use ->getObjectApi()->showTree()
   * @see         phpGitHubApiObject::showTree()
   */
  public function listObjectTree($username, $repo, $treeSHA)
  {
    return $this->getObjectApi()->showTree($username, $repo, $treeSHA);
  }

  /**
   * @deprecated  use ->getObjectApi()->showBlob()
   * @see         phpGitHubApiObject::showBlob()
   */
  public function showObjectBlob($username, $repo, $treeSHA, $path)
  {
    return $this->getObjectApi()->showBlob($username, $repo, $treeSHA, $path);
  }

  /**
   * @deprecated  use ->getObjectApi()->listBlobs()
   * @see         phpGitHubApiObject::listBlobs()
   */
  public function listObjectBlobs($username, $repo, $treeSHA)
  {
    return $this->getObjectApi()->listBlobs($username, $repo, $treeSHA);
  }
}
