<?php

require_once(dirname(__FILE__).'/phpGitHubApiAbstract.php');

/**
 * Getting information on specific commits,
 * the diffs they introduce, the files they've changed.
 *
 * @link      http://develop.github.com/p/commits.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiCommit extends phpGitHubApiAbstract
{

  /**
   * List commits by username, repo and branch
   * http://develop.github.com/p/commits.html#listing_commits_on_a_branch
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $branch           the branch
   * @return  array                     list of users found
   */
  public function getBranchCommits($username, $repo, $branch)
  {
    $response = $this->api->get('commits/list/'.urlencode($username).'/'.urlencode($repo).'/'.urlencode($branch));

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
  public function getFileCommits($username, $repo, $branch, $path)
  {
    $response = $this->api->get('commits/list/'.urlencode($username).'/'.urlencode($repo).'/'.urlencode($branch).'/'.urlencode($path));

    return $response['commits'];
  }

  /**
   * Show a specific commit
   * http://develop.github.com/p/commits.html#showing_a_specific_commit
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $sha              the commit sha
   */
  public function getCommit($username, $repo, $sha)
  {
    $response = $this->api->get('commits/show/'.urlencode($username).'/'.urlencode($repo).'/'.urlencode($sha));

    return $response['commit'];
  }    
}
