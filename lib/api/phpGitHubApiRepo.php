<?php

require_once(dirname(__FILE__).'/phpGitHubApiAbstract.php');

/**
 * Searching repositories, getting repository information
 * and managing repository information for authenticated users.
 *
 * @link      http://develop.github.com/p/repos.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiRepo extends phpGitHubApiAbstract
{
  /**
   * Search repos by keyword
   * http://develop.github.com/p/repos.html#searching_repositories
   *
   * @param   string  $query            the search query
   * @param   string  $language         takes the same values as the language drop down on http://github.com/search
   * @param   int     $startPage        the page number
   * @return  array                     list of repos found
   */
  public function search($query, $language = '', $startPage = 1)
  {
    $response = $this->api->get('repos/search/'.urlencode($query), array(
      'language' => strtolower($language),
      'start_page' => $startPage
    ));

    return $response['repositories'];
  }

  /**
   * Get extended information about a repository by its username and repo name
   * http://develop.github.com/p/repos.html#show_repo_info
   *
   * @param   string  $username         the user who owns the repo
   * @param   string  $repo             the name of the repo
   * @return  array                     informations about the repo
   */
  public function show($username, $repo)
  {
    $response = $this->api->get('repos/show/'.urlencode($username).'/'.urlencode($repo));

    return $response['repository'];
  }

  /**
   * Get the repositories of a user
   * http://develop.github.com/p/repos.html#list_all_repositories
   *
   * @param   string  $username         the username
   * @return  array                     list of the user repos
   */
  public function getUserRepos($username)
  {
    $response = $this->api->get('repos/show/'.urlencode($username));

    return $response['repositories'];
  }

  /**
   * Get the tags of a repository
   * http://develop.github.com/p/repos.html#repository_refs
   *
   * @param   string  $username         the username
   * @param   string  $repo             the name of the repo
   * @return  array                     list of the repo tags
   */
  public function getRepoTags($username, $repo)
  {
    $response = $this->api->get('repos/show/'.urlencode($username).'/'.urlencode($repo).'/tags');

    return $response['tags'];
  }

  /**
   * Get the contributors of a repository
   * http://develop.github.com/p/repos.html
   *
   * @param   string  $username         the username
   * @param   string  $repo             the name of the repo
   * @param   boolean $includingNonGithubUsers by default, the list only shows GitHub users. You can include non-users too by setting this to true
   * @return  array                     list of the repo contributors
   */
  public function getRepoContributors($username, $repo, $includingNonGithubUsers = false)
  {
    $url = 'repos/show/'.urlencode($username).'/'.urlencode($repo).'/contributors';
    if($includingNonGithubUsers)
    {
      $url .= '/anon';
    }
    $response = $this->api->get($url);

    return $response['contributors'];
  }

  /**
   * Get the branches of a repository
   * http://develop.github.com/p/repos.html#repository_refs
   *
   * @param   string  $username         the username
   * @param   string  $repo             the name of the repo
   * @return  array                     list of the repo branches
   */
  public function getRepoBranches($username, $repo)
  {
    $response = $this->api->get('repos/show/'.urlencode($username).'/'.urlencode($repo).'/branches');

    return $response['branches'];
  }

  /**
   * create repo
   * http://develop.github.com/p/repo.html
   *
   * @param   string  $name             name of the repository
   * @param   string  $description      repo description
   * @param   string  $homepage         homepage url
   * @param   bool    $public           1 for public, 0 for private
   * @return  array                     returns repo data
   */
  public function create($name, $description = '', $homepage = '', $public = true)
  {
    $response = $this->api->post('repos/create', array(
      'name'        => $name,
      'description' => $description,
      'homepage'    => $homepage,
      'public'      => $public
    ));

    return $response['repository'];
  }


  /**
   * delete repo
   * http://develop.github.com/p/repo.html
   *
   * @param   string  $name             name of the repository
   * @param   string  $token            delete token
   * @param   string  $force            force repository deletion
   *
   * @return  string|array              returns delete_token or repo status
   */
  public function delete($name, $token = null, $force = false)
  {
    if ($token === null) 
    {
      $response = $this->api->post('repos/delete/'.urlencode($name));

      $token = $response['delete_token'];

      if (!$force) 
      {
        return $token;
      }
    }

    $response = $this->api->post('repos/delete/'.urlencode($name), array(
      'delete_token'  => $token,
    ));

    return $response;
  }
}
