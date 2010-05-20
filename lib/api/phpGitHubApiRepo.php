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
   * @return  array                     list of repos found
   */
  public function search($query)
  {
    $response = $this->api->get('repos/search/'.urlencode($query));

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
}