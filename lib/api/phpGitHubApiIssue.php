<?php

require_once(dirname(__FILE__).'/phpGitHubApiAbstract.php');

/**
 * Listing issues, searching, editing and closing your projects issues.
 * http://develop.github.com/p/issues.html
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiIssue extends phpGitHubApiAbstract
{

  /**
   * List issues by username, repo and state
   * http://develop.github.com/p/issues.html#list_a_projects_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $state            the issue state, can be open or closed
   * @return  array                     list of users found
   */
  public function getList($username, $repo, $state = 'open')
  {
    $response = $this->api->get('issues/list/'.$username.'/'.$repo.'/'.$state);

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
  public function search($username, $repo, $state, $searchTerm)
  {
    $response = $this->api->get('issues/search/'.$username.'/'.$repo.'/'.$state.'/'.$searchTerm);

    return $response['issues'];
  }

  /**
   * Get extended information about an issue by its username, repo and number
   * http://develop.github.com/p/issues.html#view_an_issue
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $issueNumber      the issue number
   * @return  array                     informations about the issue
   */
  public function show($username, $repo, $issueNumber)
  {
    $response = $this->api->get('issues/show/'.$username.'/'.$repo.'/'.$issueNumber);

    return $response['issue'];
  }

  /**
   * Create a new issue for the given username and repo.
   * The issue is assigned to the authenticated user. Requires authentication.
   * http://develop.github.com/p/issues.html#open_and_close_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $issueTitle       the new issue title
   * @param   string   $issueBody       the new issue body
   * @return  array                     informations about the issue
   */
  public function open($username, $repo, $issueTitle, $issueBody)
  {
    $response = $this->api->post('issues/open/'.$username.'/'.$repo, array(
      'title' => $issueTitle,
      'body'  => $issueBody
    ));

    return $response['issue'];
  }

  /**
   * Close an existing issue. Requires authentication.
   * http://develop.github.com/p/issues.html#open_and_close_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $issueTitle       the issue number
   * @return  array                     informations about the issue
   */
  public function close($username, $repo, $issueNumber)
  {
    $response = $this->api->post('issues/close/'.$username.'/'.$repo.'/'.$issueNumber);

    return $response['issue'];
  }

  /**
   * Repoen an existing issue. Requires authentication.
   * http://develop.github.com/p/issues.html#open_and_close_issues
   *
   * @param   string  $username         the username
   * @param   string  $repo             the repo
   * @param   string  $issueTitle       the issue number
   * @return  array                     informations about the issue
   */
  public function reOpen($username, $repo, $issueNumber)
  {
    $response = $this->api->post('issues/reopen/'.$username.'/'.$repo.'/'.$issueNumber);

    return $response['issue'];
  }
}